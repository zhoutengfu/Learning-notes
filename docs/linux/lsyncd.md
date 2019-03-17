## 背景
由于出于安全考虑，公司需要对项目中的静态文件、数据库数据进行容灾备份。提出需求后公司运维组给出方案。使用lsyncd服务。
## Lsyncd介绍
Lysncd 实际上是lua语言封装了 inotify 和 rsync 工具，采用了 Linux 内核（2.6.13 及以后）里的 inotify 触发机制，然后通过rsync去差异同步，达到实时的效果。我认为它最令人称道的特性是，完美解决了 inotify + rsync海量文件同步带来的文件频繁发送文件列表的问题 —— 通过时间延迟或累计触发事件次数实现。另外，它的配置方式很简单，lua本身就是一种配置语言，可读性非常强。lsyncd也有多种工作模式可以选择，本地目录cp，本地目录rsync，远程目录rsyncssh。    

lsyncd会密切监测本地服务器上的参照目录，当发现目录下有文件或目录变更后，立刻通知远程服务器，并通过rsync 或rsync+ssh方式实现文件同步。这样做的好处就是，你可以利用Lsyncd搭建一个VPS同步镜像，应用场景例如CDN镜像、网站数据备份、网站搬家等等。
## Server端安装
安装lsyncd ：`apt-get install lsyncd`；

创建 rsync 服务端配置文件：`sudo vim /etc/rsyncd.conf`；
    
```text
 uid             = root
 gid             = root
 use chroot      = yes
 #最大连接数量，0表示没有限制
 max connections = 10
 #指定rsync的日志文件，而不把日志发送给syslog
 log file        = /var/log/rsyncd/rsyncd.log
 #rsync daemon的pid文件
 pid file        = /var/run/rsyncd.pid
 #指定锁文件 
 lock file       = /var/run/rsyncd.lock
###########下面指定模块，并设定模块配置参数，可以创建多个模块###########
 [test] # 第一个模块的ID
 # 第一个模块的ID
 path         = /data/test/
 #只读
 read only    = no
 #不隐藏该模板
 list         = yes
 #这里使用的不是系统用户，而是虚拟用户。不设置时，默认所有用户都能连接，但使用的是匿名连接
 auth users   = {{userName}}
 #保存auth users用户列表的用户名和密码，每行包含一个username:passwd。
 #由于"strict modes"默认为true，所以此文件要求非rsync daemon用户不可读写。只有启用了auth users该选项才有效。
 secrets file = /etc/images.pas
 ```
创建密码文件： `sudo vim /etc/images.pas` 
```text
{{userName}}:{{password}}
```
修改密码文件权限: `sudo chmod 600 /etc/images.pas`；

启动服务: `/etc/init.d/rsync start`
## Client端安装
安装lsyncd ：`apt-get install lsyncd`；

创建 lsyncd 实时同步配置文件： `sudo vim /etc/lsyncd.conf`；
```text
settings {
    -- 日志文件存放位置
    logfile      = "/var/log/lsyncd/lsyncd.log",
    -- 监控目录状态文件的存放位置
    statusFile   = "/var/log/lsyncd/lsyncd.status",
    -- 指定要监控的事件,如,CloseWrite,Modify,CloseWrite or Modify
    inotifyMode  = "CloseWrite",
    -- 指定同步时进程的最大个数
    maxProcesses = 1000,
    -- 当事件被命中累计多少次后才进行一次同步(即使间隔低于statusInterval)
    maxDelays    = 200,
}

sync {
    -- lsyncd运行模式
	-- default.direct=本地目录间同步
	-- default.rsync=使用rsync
	-- default.rsyncssh=使用rsync的ssh模式
    default.rsync,
    -- 同步的源目录
    source    = "/data/test/",
    -- 同步的目标目录
    target    = "{{userName}}@210.36.158.XXX::test",
    -- 等待rsync同步延时时间(秒)
    delay     = 100,
    exclude   = "",
    -- 是否同步删除 true=同步删除 false=增量备份
    delete    = false,
    rsync     = {
        binary        = "/usr/bin/rsync",
        password_file = "/etc/images.pas",
        archive       = true,
        -- 压缩传输默认为true
        compress      = true,
        verbose       = true
    }
}
 ```
创建文件夹: mkdir /var/log/lsyncd
创建密码文件: `sudo vim /etc/images.pas`；  
```text
{{password}} 
```
修改密码文件权限: `sudo chmod 600 /etc/images.pas`

启动进程: `lsyncd -log Exec /etc/lsyncd.conf`

## 背景
    由于出于安全考虑，公司需要对项目中的静态文件、数据库数据进行远程备份。提出需求后公司运维组给出方案。使用lsyncd服务。
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
 max connections = 10
 log file        = /var/log/rsyncd/rsyncd.log
 pid file        = /var/run/rsyncd.pid
 lock file       = /var/run/rsyncd.lock

 [test]
 path         = /data/test/
 read only    = no
 list         = yes
 auth users   = {{userName}}
 secrets file = /etc/images.pas
 ```
    创建密码文件： `sudo vim /etc/images.pas`
 
```text
{{userName}}:{{password}}
```
    启动服务: `/etc/init.d/rsync start`
## Client端安装
    安装lsyncd ：`apt-get install lsyncd`；
    创建 lsyncd 实时同步配置文件： `sudo vim /etc/lsyncd.conf`；
    
```text
settings {
     logfile      = "/var/log/lsyncd/lsyncd.log",
     statusFile   = "/var/log/lsyncd/lsyncd.status",
     inotifyMode  = "CloseWrite",
     maxProcesses = 1000,
     maxDelays    = 200,
}

sync {
     default.rsync,
     source    = "/data/test/",
     target    = "{{userName}}@210.36.158.XXX::test",
     delay     = 100,
  	 exclude   = "",
     delete    = false,
     rsync     = {
         binary        = "/usr/bin/rsync",
         password_file = "/etc/images.pas",
         archive       = true,
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
    启动进程: `lsyncd -log Exec /etc/lsyncd.conf`

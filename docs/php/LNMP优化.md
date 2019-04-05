## 操作系统

#### 保证操作系统安装了最新的更新和安全修复

ubuntu

> apt-get update <br/>
> apt-get upgrade 

CentOS

> yum update

#### 创建非根用户并加入到sudo用户组

Ubuntu

> adduser deploy<br/>
> usermod -a -G sudo deploy

CentOS

> adduser deploy<br/>
> passwd deploy<br/>
> usermod -a -G wheel deploy

#### SSH秘钥对认证，在本地设备可以执行ssh命令以非根用户deploy的身份免密登录服务器

本地设备

> ssh-keygen<br/>
> scp ~/.ssh/id_rsa.pub deploy@123.123.123.123:

服务器

> mkdir ~/.ssh<br/>
> touch ~/.ssh/anthorized_keys<br/>
> cat ~/id_rsa.pub >> ~/.ssh/anthorized_keys<br/>
> chown -R deploy:deploy ~/.ssh<br/>
> chmod 700 ~/.ssh<br/>
> chmod 600 ~/.ssh/anthorized_keys

#### 禁用密码登录和root用户登录

> vim /etc/ssh/sshd_config

```text
PasswordAuthentication 设置成No
PermitRootLogin 设置成No
```

Ubuntu
> sudo service ssh restart

CentOS 

> sudo systemctl restart sshd.service

## PHP-FPM

默认情况下这两个设置可能被注释掉了，
如果需要，去掉注释。这两个设置的作用是，
如果在指定的一段时间内有指定个子进程失效了，
让PHP-FPM主进程重启。
这是PHP-FPM进程的基本安全保障，能解决简单的问题。
但是不能解决由劣质的PHP代码引起的重大问题。

> vim php-fpm.conf

```text
emergency_restart_threshold = 10 
# 在指定的一段时间内，如果失效的PHP-FPM子进程超过这个值，PHP-FPM主进程就优雅重启.

emergency_restart_interval= 1m
# 设定emergency_restart_threshold设置采用的时间跨度。

listen = 127.0.0.1:9000
# PHP-FPM进程池监听的IP地址和端口号，让PHP-FPM只接受nginx从这里传入的请求。
# 127.0.0.1：9000让指定的PHP-FPM进程池监听本地端口9000进入的连接。

listen.allowed_clients = 127.0.0.1
# 可以向这个PHP-FPM进程池发送请求的IP地址（一个或多个）。
# 这个设置可能被注释掉了，如果需要，去掉这个设置的注释。
    
pm.max_children = 51
# 这个设置设定任何时间点PHP-FPM进程池中最多能有多少个进程。这个设置没有绝对值，
# 你应该测试你的PHP应用，确定每个PHP进程需要使用多少内存，然后把这个设置设为可用没存能容纳的PHP进程总数。
# 计算方式（能使用的内存）/（每个进程使用的内存）

pm.start_servers = 3
# PHP-FPM启动是PHP-FPM进程池中立即可用的进程数

pm.min_spare_servers =2
# PHP应用空闲时PHP-FPM进程池中可以存在的进程数量最小值。这个设置的值一般与pm.start_servers设置的值一样。

pm.mac_spare_server = 4
# PHP应用空闲时PHP-FPM进程池中可以存在的进程数量最大值。这个设置的值一般比pm.start_servers设置的大一点。

pm.max_requests = 1000
# 回收进程前，PHP-FPM进程池中各个进程最多能处理的HTTP请求数量。建议设置为1000

slowlog = /path/to/slowlog.log
# 这个设置的值是一个日志文件在文件系统的绝对路径。这个日志文件用于记录处理时间超过n秒的请求信息。

request_slowlog_timeout= 5s
# 如果当前请求的处理时间超过指定的值，就把请求的回溯信息写入slowlog设置的指定日志文件。

```
Ubuntu
> sudo service php5-fpm restart

CentOS
> sudo systemctl restart php-fpm.service

#### 文件上传

```text
file_uploads = 1
upload_max_filesize = 10M
max_file_uploads = 3 
# 默认情况下，PHP允许在单次请求中上传20个文件，上传的每个文件最大为2MB，你可能不想允许同事上传20个文件，
# 我只允许单次上传3个文件。
```

注意：
如果需要上传非常大的文件，web服务器的配置也要做出相应调整。除了在php.ini文件中设置，
可能还要调整nginx虚拟主机配置中的client_max_body_size设置

#### 最长执行时间

```text
max_execution_time = 5 
# 注意：在PHP脚本找给你可以调用set_time_limit()函数覆盖这个设置
```

如果PHP脚本不能长时间运行。PHP的运行的时间越长，web应用的访问者等待响应的时间就会越长。
如果有长时间运行的任务（例如，调整图像尺寸或生成报告），要在单独的职责中运行。

建议：使用PHP中的exec()函数调用bash的at命令。这个命令的作用是派生单独的非阻塞进程，
不耽误当前的PHP进程。

#### 处理会话

若想在PHP中访问Memcached存储的数据，要安装连接Memcached的PECL扩展。
然后再把下列两行添加到php.ini文件中，把PHP默认的会话存储方式改为Memcached：
```text
session.save_handler = "memcached"
session.save_path = '127.0.0.1:11211'
```
















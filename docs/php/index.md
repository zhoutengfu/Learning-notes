### 内置的PHP服务器

```text
php -S localhose:4000
```

如果需要同域下其他服务器也要访问

```text
php -S 0.0.0.0:4000
```

如果需要制定PHP配置文件

```text
php -S localhose:4000 -c app/config/php.ini
```

制定入口文件
```text
php -S localhost:8000 router.php
```

查看使用的是不是PHP内置服务器
```PHP
echo php_sapi_name();
```

#### 缺点：

PHP内置服务器不能在生产环境使用，只能在本地开发环境使用。如果在生产环境使用PHP内置的web服务器，会让很多用户失望，还会受到pingdom发出的大量下线通知。

* 内置服务器性能不是很好，因为一次只能处理一个请求，其他请求会受到阻塞。如果某个PHP文件必须等待慢速的数据库查询得到的结果或者远程API返回响应，web应用会处于停顿状态。
* 内置的服务器只支持少量的媒体文件
* 内置的服务器通过路由器脚本支持少量的url重写规则。如果需要更高级的url重写规则，要使用Apache或nginx。


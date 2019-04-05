## [自定义session存储](https://github.com/zhoutengfu/Learning-notes/tree/master/PHP/SessionHandlerInterface)

SessionHandlerInterface是一个用于创建自定义会话处理程序的原型定义的接口。
为了使用面向对象调用将自定义会话处理程序传递给会话集存储处理程序()，类必须实现此接口。

请注意，这个类的回调方法被设计为由PHP内部调用，而不是从用户空间代码中调用。

```PHP
SessionHandlerInterface {
    /* 方法 */
    abstract public close ( void ) : bool
    abstract public destroy ( string $session_id ) : bool
    abstract public gc ( int $maxlifetime ) : int
    abstract public open ( string $save_path , string $session_name ) : bool
    abstract public read ( string $session_id ) : string
    abstract public write ( string $session_id , string $session_data ) : bool
}
```

| 方法 | 说明 |
| ------ | ------ | 
| open | 方法用于基于文件的session存储系统, 该方法中可不放置任何代码，可以将其置为空方法 | 
| close | 和open 方法一样，也可以被忽略，对大多数驱动而言都用不到该方法。 | 
| read | 应该返回与给定$sessionId, 相匹配的session数据的字符串版本。 | 
| write | 应该讲给定$data 写到持久化存储系统相应的$sessionId destroy | 
| destroy | 从持久化存储中移除 $sessionId 对应的数据。 | 
| gc | 方法销毁大于给定 $lifetime 的所有session数据，对本身拥有过期机制的系统如 Memcached 和 Redis 而言，该方法可以留空。 | 

#### 我们自定义使用Mysql存储session

> SessionHandlerDb.php
```PHP
class SessionHandlerDb implements SessionHandlerInterface
{
    private $link;

    //存放过期时间
    private $lifetime = 180;

    public function open($savePath, $session_name)
    {
        //连接数据库
        $this->link = mysqli_connect('localhost', 'root', 'root');
        mysqli_set_charset($this->link, 'utf8');
        mysqli_select_db($this->link, 'test');
        if ($this->link) {
            return true;
        }
        return false;
    }

    public function close()
    {
        mysqli_close($this->link);
        return true;
    }

    /**
     * 读取session
     */
    public function read($session_id): string
    {
        //安全处理传入的session_id
        $session_id = mysqli_escape_string($this->link, $session_id);

        $sql = "select * from sessions where session_id = '{$session_id}' and session_expires > " . time();
        $result = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return $row['session_data'];
        } else {
            return '';
        }
    }

    public function write($session_id, $session_data)
    {
        //过期时间
        $new_expires = time() + $this->lifetime;

        //处理传入的session_id
        $session_id = mysqli_escape_string($this->link, $session_id);
        //查询指定session_id是否存在，存在则更新数据；不存在，则写入数据
        $sql = "select * from sessions where session_id = '{$session_id}'";
        $result = mysqli_query($this->link, $sql);

        //判断是否存在
        if (mysqli_num_rows($result) == 1) {
            $sql = "update sessions set session_expires = '{$new_expires}', session_data = '{$session_data}' where session_id = '{$session_id}'";

        } else {
            $sql = "insert into sessions values ( '{$new_expires}', '{$session_data}','{$session_id}')";
        }
        mysqli_query($this->link, $sql);
        if (mysqli_affected_rows($this->link) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($session_id)
    {
        $session_id = mysqli_escape_string($this->link, $session_id);
        $sql = "delete from sessions where session_id = '{$session_id}'";
        mysqli_query($this->link, $sql);
        return mysqli_affected_rows($this->link) == 1;
    }

    //垃圾回收
    public function gc($maxlifetime)
    {
        $sql = "delete from sessions where session_expires < " . time();
        mysqli_query($this->link, $sql);
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        }
        return false;
    }
}
```
> index.php

```PHP
require_once './SessionHandlerDb.php';
$CustomSession = new SessionHandlerDb;
ini_set('session.save_handler', 'user');
session_set_save_handler($CustomSession, true);
session_start();
$_SESSION['username'] = '周藤福';
$_SESSION['age'] = 26;
$_SESSION['email'] = '931945321@qq.com';

var_dump($_SESSION);
```

启动命令服务

> php -S localhost:8080

[php -S启动服务](/php/index.md)

页面访问：
```text
array(3) { ["username"]=> string(9) "周藤福" ["age"]=> int(26) ["email"]=> string(16) "931945321@qq.com" }
```

#### 问题：此时我们发现过期后的session没有被清理，这是为什么呢？

session.gc_divisor 与 session.gc_probability 合起来定义了在每个会话初始化时启动 gc（garbage collection 垃圾回收）进程的概率。
此概率用 gc_probability/gc_divisor 计算得来。例如 1/100 意味着在每个请求中有 1% 的概率启动 gc 进程。
session.gc_divisor 默认为 100。原来gc触发是有概率的。

编辑代码查看本地配置：
```PHP
require_once './SessionHandlerDb.php';
$CustomSession = new SessionHandlerDb;
ini_set('session.save_handler', 'user');
session_set_save_handler($CustomSession, true);

var_dump(ini_get('session.gc_probability'));
var_dump(ini_get('session.gc_divisor'));
```

页面访问：
```text
string(1) "1" string(4) "1000"
```

原来我宿主机默认配置是千分之一的概率

再次编辑将出发概率改成100%
```PHP
require_once './SessionHandlerDb.php';
$CustomSession = new SessionHandlerDb;
ini_set('session.save_handler', 'user');
session_set_save_handler($CustomSession, true);
var_dump(ini_set('session.gc_divisor', 1));
```

多试几次发现每次触发gc。

#### 思考：
* 为什么gc触发是概率
* 能不能直接改成100%触发GC

我们知道php是单进程同步执行代码。但是session随时都会过期，那么如果想要及时处理掉过期的session。就需要每次请求，都出发GC。那么对性能影响很大。


参考：

- [Sessions共享技术设计](https://segmentfault.com/a/1190000016054843)
- [php手册](https://www.php.net/manual/zh/class.sessionhandlerinterface.php)
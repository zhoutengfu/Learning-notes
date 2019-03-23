### 一、 __construct()，类的构造函数

PHP 5 允行开发者在一个类中定义一个方法作为构造函数。具有构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。

> 通常构造方法被用来执行一些有用的初始化任务，如对成员属性在创建对象时赋予初始值。
#### Example1
构造方法是对象创建完成后第一个被对象自动调用的方法。在每个类中都有一个构造方法，如果没有显示地声明它，那么类中都会默认存在一个没有参数且内容为空的构造方法。
```PHP
class BaseClass
{
    public function __construct()
    {
        echo "I am construct\n";
    }
}

$construct = new BaseClass();

// result : I am construct
```
#### Example2
当子类自己本身定义构造函数，那么子类将覆盖父类的构造方法。
```PHP
class BaseClass
{
    public function __construct()
    {
        echo "I base construct\n";
    }
}

class SubClass extends BaseClass
{
    public function __construct()
    {
        echo "I am sub construct\n";
    }
}

new SubClass();

// result : I am sub construct
```

#### Example3
当子类需要使用父类的构造方法的时候，可以通过parent::__construct();方法调用父类构造函数
```PHP
class BaseClass
{
    public function __construct()
    {
        echo "I base construct\n";
    }
}

class SubClass extends BaseClass
{
    public function __construct()
    {
        parent::__construct();
        echo "I am sub construct\n";
    }
}

new SubClass();

// results : I am base construct
             I am sub construct             
```
-----
### 二、__destruct()，类的析构函数
析构方法允许在销毁一个类之前执行的一些操作或完成一些功能，比如说关闭文件、释放结果集等。

> 一般来说，析构方法在PHP中并不是很常用，它属类中可选择的一部分，通常用来完成一些在对象销毁前的清理任务。
```PHP
class destruct
{
    public function __destruct()
    {
        echo "我是destruct\n";
    }
}

echo "1\n";
$destruct = new destruct();
echo "2\n";
unset($destruct);
echo "3\n";
$destruct1 = new destruct();
echo "4\n";
$destruct2 = new destruct();
echo "5\n";
```
results：
<pre> 
1
2
我是destruct
3
4
5
我是destruct
我是destruct
</pre>
用户使用unset主动销毁对象或者系统自动释放变量都会触发destruct析构函数。

****

三、 __call()，在对象中调用一个不可访问方法时调用。
该方法有两个参数，第一个参数 $function_name 会自动接收不存在的方法名，第二个 $arguments 则以数组的方式接收不存在方法的多个参数。
> 为了避免当调用的方法不存在时产生错误，而意外的导致程序中止，可以使用 __call() 方法来避免。
  该方法在调用的方法不存在时会自动调用，程序仍会继续执行下去。
  
#### Example1
```php
class call
{
    public function indexAction()
    {
        echo 'indexAction'."\n";
    }

    public function __call($name, $arguments)
    {
        echo $name.'方法不存在';
    }
}

$obj = new call();
$obj->index();
```
return
```text
index方法不存在
```
#### Example2
```php
class call
{
    public function indexAction($a, $b, $c)
    {
        var_dump($a);
        var_dump($b);
        var_dump($c);
    }

    public function index2Action($a, $b)
    {
        var_dump($a);
        var_dump($b);
    }

    public function __call($name, $arguments)
    {
        $actionName = $name . 'Action';
        call_user_func_array(array($this, $actionName), $arguments);
    }
}

$obj = new call();
$obj->index(1, 2, [3,4]);
$obj->index2(4, 5);
```
results：
```text
int(1)
int(2)
array(2) {
    [0]=>
    int(3)
    [1]=>
    int(4)
}
int(4)
int(5)
```
----
四、 __callStatic()，用静态方式中调用一个不可访问方法时调用

> 此方法与上面所说的 __call() 功能除了 __callStatic() 是为静态方法准备的之外，其它都是一样的。
#### Example
```PHP
class CallStatic
{
    public static function indexAction()
    {
        echo "indexAction\n";
    }

    /**
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        echo "静态方法{$name}不存在\n";
    }
}

$obj = new CallStatic();
$obj::indexAction();
$obj::index1Action();
```
results：
```text
indexAction
静态方法index1Action不存在
```

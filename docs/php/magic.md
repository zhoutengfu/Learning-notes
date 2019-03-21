### 一、 __construct()，类的构造函数

PHP 5 允行开发者在一个类中定义一个方法作为构造函数。具有构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。

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


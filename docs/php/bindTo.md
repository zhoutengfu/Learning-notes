### [闭包](https://github.com/zhoutengfu/Learning-notes/tree/master/PHP/BindTo)

```PHP
$closure = function ($name) {
    return sprintf("Hello %s", $name);
};

echo $closure('josh');


$numbersPlusOne = array_map(function ($number){
    return $number+1;
},[1, 23,3]);

print_r($numbersPlusOne);

function enclosePerson($name)
{
    return function ($doCommand) use ($name) {
        return sprintf('%s %s', $name, $doCommand);
    };
}

$clay = enclosePerson('Clay');
echo $clay('get me sweet tea');

```

#### bindTo

将回调函数绑定到类上

```PHP
class App
{
    protected $routes = array();
    protected $responseBody = 'Hello world';

    public function addRoute($routePath, $routeCallback)
    {
        $this->routes[$routePath] = $routeCallback->bindTo($this, __CLASS__);
    }

    public function dispatch($currentPath)
    {
        foreach ($this->routes as $routePath => $callback) {
            if ($routePath === $currentPath) {
                $callback();
            }
        }

        echo $this->responseBody;
    }
}

$app = new App();
$app->addRoute('user/josh',function (){
    $this->responseBody = '{"name":"josh"}';
});

$app->dispatch('user/josh');
```
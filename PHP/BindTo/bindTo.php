<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-29
 * Time: 21:52
 */

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
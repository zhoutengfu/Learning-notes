### 创建第一个package

首先去github创建一个项目，那么我的项目叫[firstPackage](https://github.com/zhoutengfu/FirstPackage).
项目创建以后本地拉取代码。

#### 项目composer初始化

```text
composer init
```

按照提示生成composer.json文件

```text
{
  "name": "zhoutengfu/first-package",
  "description": "常用帮助方类",
  "homepage": "https://github.com/zhoutengfu/first-package",
  "license": "MIT",
  "keywords": [
    "package",
    "psr-4"
  ],
  "authors": [
    {
      "name": "zhoutengfu",
      "email": "931945321@qq.com"
    }
  ],
  "require": {},
  "repositories": [
    {
      "type": "composer",
      "url": "https://packagist.org"
    }
  ]
}
```


#### 开始对我们的第一个package添加一些功能吧！我准备给我的第一个package添加help类。

推荐结构我们将我们的组件放在src目录下。

```php
<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-31
 * Time: 17:21
 */

namespace ZTF\FirstPackage;

class Helper
{
    /**
     * @param $price
     * @param int $digit
     * @return float
     */
    public static function price($price, $digit = 2)
    {
        return round($price, $digit);
    }

    public static function vdump($var)
    {
        var_dump($var);
        exit();
    }

    public static function checkMobile($mobile)
    {
        return preg_match("/^1[3,5,7,8][0-9]{9}$/", $mobile) === 1;
    }

    public static function intValueWithDefault($val, $def = 0)
    {
        $val = intval($val);
        return $val ? $val : $def;
    }

    public static function genOrderId()
    {
        return date('YmdHis') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public static function makeUploadPath($dir = '')
    {
        $path = date("Y/m/d", time());
        if ($dir) {
            $path = sprintf('up/%s/%s', $dir, $path);
        } else {
            $path = sprintf('up/%s', $path);
        }
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

    public static function encryptPassword($password, $salt)
    {
        return sha1($salt . $password . $salt);
    }

    /**
     * 获取字符串中的汉字
     * @param $str
     * @return string
     */
    public static function getChinese($str)
    {
        preg_match_all("/./u", $str, $strArr);
        $result = '';
        foreach ($strArr[0] as $k) {
            if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $k)) {
                $result .= $k;
            }
        }
        return $result;
    }
}
```

#### 设置autoload
我们可以看到我给类添加的命名空间为ZTF\FirstPackage，我们需要给composer.json添加autoload配置

```text
  "autoload": {
    "psr-4": {
      "ZTF\\FirstPackage\\": "src/"
    }
  },
```

直接把命名空间指到src目录下面，之后我们将代码提交到github上面。

#### 将项目添加到packgist上

这里我们需要注意，需要先对项目打上release标签，不然就算项目添加到packgist上面，也拉取不下来。

我把项目打了一个1.0.1，接着去packgist添加项目。

添加完项目我们就可以在我们项目中使用了。

注意：我们需要对packgist对一个webhook，当项目有新的推送的时候，让packgist自动更新。

```PHP
include_once './vendor/autoload.php';
\ZTF\FirstPackage\Helper::vdump(111);
```


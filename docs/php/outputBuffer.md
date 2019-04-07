## outputBuffer


默认情况下，php buffer是开启的，而且该buffer默认值是4096，即1kb。你可以通过在php.ini配置文件中找到output_buffering配置.当echo,print等输出用户数据的时候，输出数据都会写入到php output_buffering中，直到output_buffering写满，会将这些数据通过tcp传送给浏览器显示。你也可以通过 ob_start()手动激活php output_buffering机制，使得即便输出超过了1kb数据，也不真的把数据交给tcp传给浏览器，因为ob_start()将php buffer空间设置到了足够大 。只有直到脚本结束，或者调用ob_end_flush函数，才会把数据发送给客户端浏览器。

通过vim /usr/local/etc/php/7.1/php.ini
```text
output_buffering = 4096
```

#### flush和ob_flush

```PHP
if (ob_get_level() == 0) ob_start();

for ($i = 0; $i<10; $i++){
    echo "<br> Line to show.";

    ob_flush();
    flush();
    sleep(2);
}

echo "Done.";

ob_end_flush();
```

我们可以看到每隔2秒钟页面更新。

##### 如果把ob_flush()注释掉。

```PHP
if (ob_get_level() == 0) ob_start();

for ($i = 0; $i<10; $i++){
    echo "<br> Line to show.";

    //ob_flush();
    flush();
    sleep(2);
}

echo "Done.";

ob_end_flush();
```

发现页面就不再每隔2秒刷新，20秒后一次性出来。

##### 我们知道output_buffering=4096,那我们把每次输出的大小填充到一个缓冲区的大小

```PHP
if (ob_get_level() == 0) ob_start();

for ($i = 0; $i<10; $i++){
    echo "<br> Line to show.";
    echo str_pad('',4096)."\n";

    flush();
    sleep(2);
}

echo "Done.";

ob_end_flush();
```
我们可以看到页面又每隔2秒页面更新。这一点和我们上面看到的得到了验证。

#### ob_clean

```PHP
ob_start();

echo "Hello ";
ob_clean();
$len1 = ob_get_length();

echo "World";

$len2 = ob_get_length();

ob_end_clean();

echo $len1 . "|" . $len2;
```

得到的结果是0|5.前面输出的"Hello"被清除掉了。

#### ob_end_clean和ob_end_flush

```PHP
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';

$aa = ob_end_clean();

echo ob_get_level(),'<br/> ';

```
我们可以看到的结果是122

```PHP
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';

ob_end_flush();
echo ob_get_level(),'<br/> ';
```

因为output_buffering = 4096，默认存在一个缓冲区(理解名为”buffer_A”区块)，所以第一次echo ob_get_level()结果为1，且该结果是保存在”buffer_A”区块中； 
第一次ob_start()开启了一个缓冲区(理解名为”buffer_B”区块),这时echo ob_get_level()结果为2，且该结果是保存在”buffer_B”区块中。 
第二次ob_start()再开启一个缓冲区(理解名为”buffer_C”区块),这时echo ob_get_level()结果为3，且该结果是保存在”buffer_C”区块中 
到此为止，所有输出并没有直接发送到web服务器。 
这时调用ob_end_clean()，将会把”buffer_C”区块给删除掉，所以结果3就不存在了 
再次echo ob_get_level()时，因为没有”buffer_C”区块，所以当前应该是2，且结果保存在”buffer_B”中。 

[参考](https://blog.csdn.net/soonfly/article/details/52105533 )

#### ob_get_clean

```PHP
ob_start();

echo "Hello World\n";

$out = ob_get_clean();

var_dump($out);

echo "Hello World222\n";

$out = ob_get_clean();
var_dump($out);
```
得到的结果是string(41) "string(12) "Hello World " Hello World222 "，
把第一次var_dump的结果，再一次var_dump导致的。

##### 试下在第二次var_dump的时候先ob_start

```PHP
ob_start();

echo "Hello World\n";

$out = ob_get_clean();

var_dump($out);

ob_start();
echo "Hello World222\n";

$out = ob_get_clean();
var_dump($out);
```

此时得到的结果就是我们原来想要的string(12) "Hello World " string(15) "Hello World222 "

#### ob_get_length

```PHP
ob_start();

echo "Hello ";

$len1 = ob_get_length();

echo "World";

$len2 = ob_get_length();

ob_end_clean();

echo $len1 . "|" . $len2;
```

我们得到的结果是6|11，获取缓冲器的长度

#### ob_get_level

```PHP
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';
```
默认情况下ob是被开启，所以开始就有一级。当我们把php.ini中的设置为0，那么第一级就是0

#### ob_gzhandler

```PHP

ob_start("ob_gzhandler");

?>
<html>
<body>
<p>This should be a compressed page.</p>
</html>
<body>
```

我们可以通过浏览器的response看到，返回的时候被gzip压缩了

#### ob_start

```PHP

function callback($buffer)
{
    // replace all the apples with oranges
    return (str_replace("apples", "oranges", $buffer));
}

ob_start("callback");

?>
    <html>
    <body>
    <p>It's like comparing apples to oranges.</p>
    </body>
    </html>
<?php

ob_end_flush();

```
ob_start的时候可以接受一个回调函数，在输出的时候会执行这个回调函数。
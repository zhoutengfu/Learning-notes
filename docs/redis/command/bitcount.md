### BITCOUNT KEY [start end]

> 从2.6.0开始有效 ，时间复杂度O(N)

字符串中设置位的个数。

默认情况下，检查字符串中包含的所有字节。只能在传递附加参数开始和结束的间隔内指定计数操作。

像GETRANGE命令一样，开始和结束可以包含负值，以便从字符串末尾开始索引字节。其中-1是最后一个字节，-2是倒数第二个字节，以此类推。

不存在key的当做空字符串，所以命令将返回0。

examples

```text
127.0.0.1:6379> set mykey "foobar"
OK
127.0.0.1:6379> BITcount mykey
(integer) 26
127.0.0.1:6379> BITCOUNT mykey 0 0
(integer) 4
127.0.0.1:6379> BITCOUNT mykey 1 1
(integer) 6
127.0.0.1:6379>
```

配合SETBIT将a变成b

'a' 的ASCII码是 97。转换为二进制是：01100001。

```text
127.0.0.1:6379> set andy a
OK
127.0.0.1:6379> get andy
"a"
127.0.0.1:6379> SETBIT andy 6 1
(integer) 0
127.0.0.1:6379> SETBIT andy 7 0
(integer) 1
127.0.0.1:6379> get andy
"b"
127.0.0.1:6379> BITCOUNT andy
(integer) 3
127.0.0.1:6379>
```

每一次SETBIT成功将返回原来位的值

一个汉字中占三个字节，11100100 10111000 10101101

```text
127.0.0.1:6379> set ch 中
OK
127.0.0.1:6379> BITCOUNT CH
(integer) 0
127.0.0.1:6379> BITCOUNT ch
(integer) 13
127.0.0.1:6379> BITCOUNT ch 0 0
(integer) 4
127.0.0.1:6379> BITCOUNT ch 1 1
(integer) 4
127.0.0.1:6379> BITCOUNT ch 2 2
(integer) 5
```

汉字一的utf8二进制标识方式：111001001011100010000000
汉字三的utf8二进制标识方式：111001001011100010001001
我们把一变成三

```text
127.0.0.1:6379> set ch 一
OK
127.0.0.1:6379> get ch
一
127.0.0.1:6379> SETBIT ch 23 1
0
127.0.0.1:6379> SETBIT ch 20 1
0
127.0.0.1:6379> get ch
三
```

需要在redis启动的时候，带上参数--raw


模式：使用bitmaps的实时度量

bitmaps是特定类型信息的非常节省空间的表示。一个例子是web应用需要用户的历史访问，以便例如可以确定哪些用户是beta特性的良好目标。


使用SETBIT命令可以简单实现，用一个渐进的小整数来识别每一天。例如，第0天是应用程序上线的第一天，第二天是第一天，依此类推。

每次用户执行页面浏览，应用程序可以使用设置与当天相对应的位的SETBIT命令来注册用户在当天访问网站。

最后只需要对bitmap调用BITCOUNT命令，就可以知道用户访问网站的单天天数。

在一篇名为“使用Redis bitmap的快速简单实时度量”的文章中描述了一个类似的模式，即使用用户标识代替天数。

性能考虑：

在上面计算天数的例子中，即使在应用程序上线10年后，我们每一个用户任然只有465*10位的数据，每个用户只有456字节，这样的数据量，BITCOUNT任然是快速的欲其他O（1）redis命令像get或者incr

当bitmap很大时，有两种选择：

* 获取每次位图修改时递增的分离key，使用一个小的redis Lua脚本，这可以非常高效和原子化。
* 使用BITCOUNT开始和结束可选参数增量运行位图，在客户端累积结果并可选的将结果缓存到key中

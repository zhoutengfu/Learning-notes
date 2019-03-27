#### APPEND key value

> 从2.0.0有效
> 时间复杂度：O(1)。因为redis使用动态字符串库将在每次重新分配两倍的可用空间，假如添加的值是小的并且目前存在的值是任意大小。则平均复杂度为O(1).

如果key是字符串并且已经存在。该命令将值追加打字符串的末尾。如果key不存在，他将创建并设置为空字符串。因此在这种特殊情况下，APPEND将类似于SET.

返回值
返回整数：追加操作后字符串的长度

例子：

```text
127.0.0.1:6379> EXISTS mykey
(integer) 0
127.0.0.1:6379> append mykey "hello"
(integer) 5
127.0.0.1:6379> append mykey "world"
(integer) 10
127.0.0.1:6379> get mykey
"helloworld"
127.0.0.1:6379>
```

模式：时间序列

APPEND命令可用于创建固定大小样本（通常称为时间序列）列表的非常紧凑的表示形式。每当新样本到达我们可以使用命令存储它

```cmd
APPEND timeseries "fixed-size sample"
```

访问时间序列中的单个元素并不难:

* STRIEN能用来获取样本的数量
* GETRANGE允许随机访问任何元素。如果我们的时间序列有相关的时间信息我们能简单的实现一个二进制搜索，结合GETRANGE和redis2.6中提供的Lua脚本引擎来获得范围
* SETRANGE可用于覆盖现有的时间序列。

这种模式的限制在于我们被迫进入仅追加操作模式，没有办法轻松的将时间序列切割成给定的大小，因为redis目前缺少一个能修剪字符串对象的命令。然而，以这种方式存贮的时间序列的空间效率是显著的。
提示：可以基于当前的Unix时间切换到不同的key。以这种方式，每个key可能只有相对少量的样本。为了避免处理非常大的key，并使用这个模式更加友好的分布在许多redis实例中。

使用固定大小字符串对传感器温度进行采样的实例（实际实现中使用二进制格式更好）

```text
127.0.0.1:6379> append ts '0043'
(integer) 4
127.0.0.1:6379> append ts '0035'
(integer) 8
127.0.0.1:6379> getrange ts 0 3
"0043"
127.0.0.1:6379> getrange ts 4 7
"0035"
127.0.0.1:6379>
```
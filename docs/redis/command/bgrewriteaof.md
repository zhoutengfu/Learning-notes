### BGWRITERAOF

> 从1.0.0开始

指示redis开始Append Only File重写过程。重写将创建当前更小优化版本。

如果BGWRITERAOF错误，因为旧的AOF文件不会触及，所以不会丢失数据。

只有没有后台进程进行持久化的情况下，重写才会由redis出发。

具体的：

* 如果redis子进程正在磁盘创建快照，则在生成RDB文件的保存终止之前，AOF重写被调度但不会开始。
这种情况下，BGWRITEAOF任然会返回一个Ok状态，但是会带适当的消息。从redis2.6开始，你可以查看info命令来检查是否调度了AOF重写。
* 如果AOF重写已经在处理，该命令返回一个错误，并且之后不会安排AOF重写。

从redis2.4开始，由redis自动触发AOF重写，然而，BGREWRITEAOF命令能在用于任务时间触发重写。

请参考持久化文档获取详细文档

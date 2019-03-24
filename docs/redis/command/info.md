### INFO [section]
INFO命令返回关于服务器的信息和统计数据，格式简单，便于计算机解析，也便于人类阅读。

可选参数可用于选择信息的特定部分:

* server：关于redis服务的一般信息
* clients：client连接的部分
* memory：内存使用相关部分
* persistence：RDB和AOF相关部分
* stats：一般统计
* replication：主/从 复制信息
* cpu：CPU使用部分
* commandstats：redis命令统计
* cluster：redis集群部分
* keyspace：数据库相关统计

它也能使用下列值：
*  all：返回所有部分
*  default：仅仅返回默认设置部分

当没有参数提供，采用default选项

返回值

```text
127.0.0.1:6379> info
# Server
redis_version:5.0.0
redis_git_sha1:00000000
redis_git_dirty:0
redis_build_id:ba88d416b02e44b2
redis_mode:standalone
os:Darwin 18.0.0 x86_64
arch_bits:64
multiplexing_api:kqueue
atomicvar_api:atomic-builtin
gcc_version:4.2.1
process_id:923
run_id:570ab88a2573fa0c9e3f1fba717292a2ffab22b3
tcp_port:6379
uptime_in_seconds:338353
uptime_in_days:3
hz:10
configured_hz:10
lru_clock:9828300
executable:/usr/local/opt/redis/bin/redis-server
config_file:/usr/local/etc/redis.conf

# Clients
connected_clients:2
client_recent_max_input_buffer:2
client_recent_max_output_buffer:0
blocked_clients:0

# Memory
used_memory:7966240
used_memory_human:7.60M
used_memory_rss:15695872
used_memory_rss_human:14.97M
used_memory_peak:185709120
used_memory_peak_human:177.11M
used_memory_peak_perc:4.29%
used_memory_overhead:1107248
used_memory_startup:987024
used_memory_dataset:6858992
used_memory_dataset_perc:98.28%
allocator_allocated:7931936
allocator_active:15654912
allocator_resident:15654912
total_system_memory:17179869184
total_system_memory_human:16.00G
used_memory_lua:40960
used_memory_lua_human:40.00K
used_memory_scripts:152
used_memory_scripts_human:152B
number_of_cached_scripts:1
maxmemory:0
maxmemory_human:0B
maxmemory_policy:noeviction
allocator_frag_ratio:1.97
allocator_frag_bytes:7722976
allocator_rss_ratio:1.00
allocator_rss_bytes:0
rss_overhead_ratio:1.00
rss_overhead_bytes:40960
mem_fragmentation_ratio:1.98
mem_fragmentation_bytes:7763936
mem_not_counted_for_evict:0
mem_replication_backlog:0
mem_clients_slaves:0
mem_clients_normal:66600
mem_aof_buffer:0
mem_allocator:libc
active_defrag_running:0
lazyfree_pending_objects:0

# Persistence
loading:0
rdb_changes_since_last_save:13
rdb_bgsave_in_progress:0
rdb_last_save_time:1553332036
rdb_last_bgsave_status:ok
rdb_last_bgsave_time_sec:0
rdb_current_bgsave_time_sec:-1
rdb_last_cow_size:0
aof_enabled:0
aof_rewrite_in_progress:0
aof_rewrite_scheduled:0
aof_last_rewrite_time_sec:-1
aof_current_rewrite_time_sec:-1
aof_last_bgrewrite_status:ok
aof_last_write_status:ok
aof_last_cow_size:0

# Stats
total_connections_received:14936
total_commands_processed:309043
instantaneous_ops_per_sec:0
total_net_input_bytes:1125885067
total_net_output_bytes:20874538134
instantaneous_input_kbps:0.00
instantaneous_output_kbps:0.00
rejected_connections:0
sync_full:0
sync_partial_ok:0
sync_partial_err:0
expired_keys:33910
expired_stale_perc:0.00
expired_time_cap_reached_count:0
evicted_keys:0
keyspace_hits:209364
keyspace_misses:36235
pubsub_channels:0
pubsub_patterns:0
latest_fork_usec:682
migrate_cached_sockets:0
slave_expires_tracked_keys:0
active_defrag_hits:0
active_defrag_misses:0
active_defrag_key_hits:0
active_defrag_key_misses:0

# Replication
role:master
connected_slaves:0
master_replid:0ab49d0b949a305c406df17e44f27bfab032dbf2
master_replid2:0000000000000000000000000000000000000000
master_repl_offset:0
second_repl_offset:-1
repl_backlog_active:0
repl_backlog_size:1048576
repl_backlog_first_byte_offset:0
repl_backlog_histlen:0

# CPU
used_cpu_sys:72.990095
used_cpu_user:59.473327
used_cpu_sys_children:9.587371
used_cpu_user_children:38.110287

# Cluster
cluster_enabled:0

# Keyspace
db0:keys=598,expires=378,avg_ttl=1784064
```
注意
请注意根据redis版本一些字段已经删除和添加。因此，健壮的客户端应用程序应该通过跳过未知属性来解析该命令的结果，并优雅地处理丢失的字段。

这是redis>=2.4字段描述
#### server所有字段的意思

* redis_version：redis版本
* redis_git_sha1：Git SHA1
* redis_git_dirty：Git dirty
* redis_build_id：构建id
* redis_mode：服务模式（独立、哨兵、集群）
* os：宿主机操作系统
* arch_bits:体系架构（32或者64）
* multiplexing_api：redis使用的事件轮训机制
* atomicvar_api：redis使用的原子API
* gcc_version：编译redis服务使用的GCC版本
* process_id：服务进程PID
* run_id: redis服务标识随机值（用于哨兵和集群）
* tcp_port：TCP/IP监听的端口
* uptime_in_seconds: redis服务启动后的秒数
* uptime_in_days: 用天表达同样的值
* hz：服务的频率设置
* lru_clock:用于LRU管理，时钟每分钟自增
* executable：服务脚本的路径
* config_file:config文件路径

#### clients部分全部字段意思

* connected_client: client连接数量(不包含复制连接)
* client_longest_output_list:当前client连接最大输出列表
* client_biggest_input_bug:当前client连接中最小输出缓冲区
* blocked_client:client等待阻塞访问client数量（BLPOP, BRPOP, BRPOPLPUSH）

#### memory部分全部字段的意思

* used_memory:分配器分配给redis分配的内存（标准libc, jemalloc或者可替换的分配器如tcmalloc）
* used_memory_human:人类可读的表达上面的值
* used_memory_rss:操作系统看到redis分配的字节数（常驻大小）这个是通过工具top和ps反馈的值
* used_memory_rss_human：同上
* used_memory_peak:redis消耗的峰值内存（字节）
* used_memory_peak_human:同上
* used_memory_overhead:服务器为管理其内部数据结构分配的所有开销的字节总和
* used_memory_startup:redis初始化消耗的内存
* used_memory_dataset:数据集的大小（used_memory-used_memory_overhead）
* used_memory_dataset_perc：已用内存数据集占净内存使用量的百分比（used_memory_dataset/(used_memory-used_memory_startup)）
* total_system_memory:redis宿主机内存总量
* total_system_memory_human:同上
* used_memory_lua:Lua引擎使用的字节数
* used_memory_lua_human:同上
* maxmemory:maxmemory配置指令的值
* maxmemory_human：同上
* maxmemory_policy:maxmemory策略配置指令的值
* mem_fragmentation_ratio:内存碎片率(used_memory_rss/used_memory)
* mem_allocator：编译时选择的内存分配器
* active_defrag_running：指示活动碎片整理是否处于活动状态的标志
* lazyfree_pending_objects：等待释放的对象（通过异步选项调用UNLINK或FLUSHDB和FLUSHALL的结果）

> 理想情况used_memory_rss只稍微高于used_memory。当rss>>used意味着内存碎片。这个可以通过mem_fragmentation_ratio查看。当used >> rss, 这意味着Redis内存的一部分已经被操作系统交换了:预计会有一些明显的延迟。

> 因为Redis无法控制其分配如何映射到内存页面，所以高used_memory_rss通常是内存使用激增的结果。

> 当redis释放没存，内存归还给分配器。分配器可能也可能不讲内存归还给系统。所以可能used_memory值和操作系统显示的值存在矛盾。它可能由于使用的内存redis已经释放，但是没有返回给系统。used_memory_peak的值通常用于确认这一点。

> 通过参考MEMORY STATS命令和MEMORY DOCTOR，可以获得关于服务器内存的其他内省信息。

#### 持久化部分全部字段的意思

* loading：标志指示dump文件是否正在载入
* rdb_changes_since_last_save：距离最近一次成功创建持久化文件之后，经过了多少秒
* rdb_bgsave_in_progress：标志指示RDB是否正在进行
* rdb_last_save_time：上一次保存RDB成功的时间
* rdb_last_bgsave_status: 上一次保存RDB文件的转态
* rdb_last_bgsave_time_sec: 上一次保存RDB文件操作的时间
* rdb_current_bgsave_time_sec: 如果当前正在保存，当前保存RDB文件的时间
* rdb_last_cow_size: 上一次RBD保存操作期间分配给写时复制的大小
* aof_enabled: 标志指示AOF日志是否开启
* aof_rewrite_in_progress: 指示正在进行AOF重写操作的标志
* aof_rewrite_scheduled:  一旦正在进行的RDB保存完成，将计划一个指示AOF重写操作的标志
* aof_last_rewrite_time_sec: 最后一次AOF重写操作的持续时间(秒)
* aof_current_rewrite_time_sec: 正在进行的AOF重写操作的持续时间(如果有)
* aof_last_bgrewrite_status: 最后一次AOF重写操作的状态
* aof_last_write_status: 对AOF的最后一次写操作的状态
* aof_last_cow_size:  在最后一次AOF重写操作期间写入时复制分配的字节大小changes_since_last_save是指自上次调用save或BGSAVE以来，在数据集中产生某种更改的操作数

如果AOF开启，这些额外的字段被添加：

* 










### INFO [section]
INFO命令返回关于服务器的信息和统计数据，格式简单，便于计算机解析，也便于人类阅读。

#### 可选参数可用于选择信息的特定部分:

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

#### 它也能使用下列值：
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
* rdb_changes_since_last_save：自上次rdb存储以来的更改次数
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

#### 如果AOF开启，这些额外的字段被添加：

* aof_current_size:AOF当前文件大小
* aof_base_size:最近一次启动或者重写AOF文件的大小
* aof_pending_rewrite:指示AOF重写操作的标志将在正在进行的RDB保存完成后调度。
* aof_buffer_length:AOF缓冲区大小
* aof_rewrite_buffer_length:AOF重写缓冲区大小
* aof_pending_bio_fsync:后台I/O队列fsync等待工作的数量
* aof_delayed_fsync:延迟的fsync数量

#### 如果load操作真在进行，这些字段将会添加：

* loading_start_time:load操作开始的时间戳
* loading_total_bytes:文件大小
* loading_loaded_bytes:已经加载的字节数
* loading_loaded_perc:百分比保存上面的值
* loading_eta_seconds:load完成预计时间

#### stats部分全部字段意思

* total_connections_received:服务连接接收的总数
* total_commands_processed:服务命令处理的总数
* instantaneous_ops_per_sec:命令每秒处理的数量
* instantaneous_input_bytes:从网络读取的字节数总和
* instantaneous_output_bytes:从网络写的字节数总和
* rejected_connections:因为maxclient限制拒绝接收的数量
* sync_full:与从服务完全完全同步数量
* sync_partial_ok:接受的部分重新同步请求的数量
* sync_partial_err:被拒绝的部分重新同步请求数
* expired_keys:过期key的总数
* evicted_keys:由于maxmemory限制拒绝的key数量
* keyspace_hits:主字典中查找成功的数量
* keyspace_misses:主字典中查找失败的数量
* pubsub_channels:具有客户端订阅的发布/订阅频道的全球数量
* pubsub_patterns:具有客户端订阅的发布/订阅模式的全局数量
* pubsub_fork_usec:最近一次fork操作微秒时间
* migrate_cached_sockets:为迁移目的socket开启的数量
* slave_expires_tracked_keys:为过期目的跟踪的key的数量（仅使用于可写版本）
* active_defrag_hits:活动碎片整理进程执行的值重新分配数
* active_defrag_misses:由活动碎片整理进程启动的中止值重新分配的数量                  
* active_defrag_key_hits:主动碎片整理key的数量
* active_defrag_key_misses:活动碎片整理进程跳过的key数

#### replication字段的意思

* role:值"master"不是从实例。"slave"该实例是某个主实例的副本。一个副本也可以是另一个副本的主（链式复制）
* master_replid:redis服务的复制ID
* master_replid2:辅助复制标识，为故障转移后同步使用
* master_repl_offset:服务的当前复制偏移量
* second_repl_offset:接受复制标识的偏移量
* repl_backlog_active:标志指示复制积压处于的活动状态
* repl_backlog_size:复制积压缓冲区总字节数
* repl_backlog_first_byte_offset:复制积压缓冲区主偏移量
* repl_backlog_histlen:复制积压的缓冲区数据的字节数

#### 如果是从服务实例，添加下列字段提供：

* master_host:master宿主机的IP地址
* master_port:tcp监听的端口
* master_link_status:连接状态（上/下）
* master_last_io_seconds_ago:自上次以来交互的秒数
* master_sync_in_progress:指示主正在同步辅助
* slave_repl_offset:复制的实例复制的偏移量
* slave_priority:实例作为故障转移候选的优先级
* slave_read_only:指示副本是否为只读的标志

#### 如果SYNC操作正在执行。添加下列字段

* master_sync_left_bytes:同步完成前剩余字节数
* master_sync_last_io_seconds_ago:自上次同步操作传输I/O期间的秒数

#### 如果主服务和从服务链接断开,添加下列字段

* master_link_down_since_seconds:自上次链接断掉的秒数

#### 始终提供以下字段

* connected_slaves:链接的副本数量

#### 如果服务配置min-slaves-to-write（或者从redis5 min-replicas-to-write）指令，添加下列字段

* min_slaves_good_slaves：当前副本良好的数量

#### 对于每个副本添加下列字段

* slave***:id, IP address, port, state, offset, lag

#### cpu部分字段的意思

* used_cpu_sys:redis服务消耗系统CPU
* used_cpu_user:redis服务消耗的用户CPU
* used_cpu_sys_children:后台进程消耗系统CPU
* used_cpu_user_children:后台进程消耗用户CPU

#### 基于命令类型commandstats部分提供统计，包含访问数量，这些命令总共消耗CPU时间和命令执行平均消耗时间。为每个命令类型添加下列字段

* cmdstat_XXX:calls=xxx,usec_per_call=XXX

#### 集群部分当前仅包含唯一字段

* cluster_enabled:指示redis集群是否开启

####  keyspace部分提供了每个数据库主词典的统计信息。统计数据是key的数量和过期key的数量。为每个库添添加一下行

* dbXXX:keys=XXX,expires:XXX

#### 关于此手册页中使用的“slave”一词,从redis5开始，如果不为了向后兼容，redis项目不再使用slave一词。不幸的是，在这个命令中，从这个词是协议的一部分，因此，只有当这个应用程序接口自然不推荐使用时，我们才能删除这样的事件。





























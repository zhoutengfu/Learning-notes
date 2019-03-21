项目中使用redis做缓存，出了问题后发现无从下手。准备好好学习下redis。那么首先从redis的info开始吧。
### info

字段 | 备注
------------ | ------------- 
# Server | 
redis_version:5.0.0 | Redis的版本
redis_git_sha1:00000000|git上版本
redis_git_dirty:0|git的代码是否修改
redis_build_id:ba88d416b02e44b2|编译时ID
redis_mode:standalone|redis运行模式 (“独立”、“哨兵”或“集群”)
os:Darwin 18.0.0 x86_64|所运行操作系统的内核
arch_bits:64|64架构
multiplexing_api:kqueue|Redis基于kqueue模型
atomicvar_api:atomic-builtin|原子处理api（官网解释为：Atomicvar API used by Redis）
gcc_version:4.2.1|gcc 版本
process_id:923|进程PID
run_id:570ab88a2573fa0c9e3f1fba717292a2ffab22b3|Redis的随机标识符(用于sentinel和集群)
tcp_port:6379|Redis 端口
uptime_in_seconds:180616|Redis运行时长的秒数
uptime_in_days:2|Redis运行的天数，与上面的时间正好相等
hz:10|服务器的频率设置
configured_hz:10|官网没有解释这个字段
lru_clock:9670563|以分钟为单位的自增时钟,用于LRU管理maxmemory-policy 内存回收策略
executable:/usr/local/opt/redis/bin/redis-server|服务器可执行文件的路径
config_file:/usr/local/etc/redis.conf|Redis.conf 配置文件目录
# Clients|
connected_clients:2|已连接客户端的数量（不包括通过从属服务器连接的客户端）
client_recent_max_input_buffer:2|当前客户端连接中最大的输入缓冲区
client_recent_max_output_buffer:0|当前客户端连接中最大的输出缓冲区
blocked_clients:0|正在等待阻塞命令（BLPOP、BRPOP、BRPOPLPUSH）的客户端的数量
# Memory|
used_memory:6460560|由Redis分配的内存的总量
used_memory_human:6.16M|由Redis分配的内存的总量，单位G            给人看的
used_memory_rss:17039360|Redis进程从OS角度分配的物理内存，如key被删除后，malloc不一定把内存归还给OS,但可以Redis进程复用，代表redis使用的总内存，除两次1024，换算成M
used_memory_rss_human:16.25M|同上
used_memory_peak:185709120|Redis使用内存的峰值
used_memory_peak_human:177.11M|同上
used_memory_peak_perc:3.48%|已用内存峰值占已用内存的百分比
used_memory_overhead:1106480|服务器为管理其内部数据结构分配的所有开销的字节总和
used_memory_startup:987024|Redis在启动时消耗的初始内存量(以字节为单位)
used_memory_dataset:5354080|数据集的字节大小(used_memory-used_memory_overhead)
used_memory_dataset_perc:97.82%|已用内存数据集占净内存使用量的百分比(used_memory-used_memory_startup)
allocator_allocated:6426256|
allocator_active:17001472|
allocator_resident:17001472|
total_system_memory:17179869184|Redis主机拥有的内存总量
total_system_memory_human:16.00G|同上
used_memory_lua:37888|lua引擎使用的内存总量，字节数；有使用lua脚本的注意监控
used_memory_lua_human:37.00K|同上
used_memory_scripts:0|
used_memory_scripts_human:0B|同上
number_of_cached_scripts:0|
maxmemory:0|maxmemory配置指令的值
maxmemory_human:0B|同上
maxmemory_policy:noeviction|maxmemory策略配置指令的值
allocator_frag_ratio:2.65|
allocator_frag_bytes:10575216|
allocator_rss_ratio:1.00|
allocator_rss_bytes:0|
rss_overhead_ratio:1.00|
rss_overhead_bytes:37888|
mem_fragmentation_ratio:2.65|内存碎片过高(如果实例比较小，这个指标可能比较大，不实用)实用的内存碎片换算：used_memory_peak-used_memory  多出来的就是内丰碎片,重启后此碎片消失。
mem_fragmentation_bytes:10613104|
mem_not_counted_for_evict:0|
mem_replication_backlog:0|
mem_clients_slaves:0|
mem_clients_normal:66600|
mem_aof_buffer:0|
mem_allocator:libc|内存分配器，在编译时选择
active_defrag_running:0|标志碎片整流器是否在执行
lazyfree_pending_objects:0|等待释放的对象(通过异步选项调用UNLINK或FLUSHDB和FLUSHALL的结果）
# Persistence|
loading:0|标志位，是否在载入数据文件，0代表没有，1 代表正在载入
rdb_changes_since_last_save:83|从最近一次dump快照后，未被dump的变更次数(和save里变更计数器类似)
rdb_bgsave_in_progress:0|标志位，记录当前是否在创建RDB快照
rdb_last_save_time:1553174297|最近一次创建RDB快照文件的Unix时间戳
rdb_last_bgsave_status:ok|标志位，记录最近一次bgsave操作是否创建成功
rdb_last_bgsave_time_sec:0|最近一次bgsave操作耗时秒数
rdb_current_bgsave_time_sec:-1|当前bgsave执行耗时秒数(-1 还没有执行)
rdb_last_cow_size:0|
aof_enabled:0|appenonly是否开启,appendonly为yes则为1,no则为0
aof_rewrite_in_progress:0|AOF重写是否正在进行
aof_rewrite_scheduled:0|AOF重写是否被RDB save操作阻塞等待
aof_last_rewrite_time_sec:-1|最近一次AOF重写操作耗时
aof_current_rewrite_time_sec:-1|当前AOF重写持续的耗时
aof_last_bgrewrite_status:ok|最近一次AOF重写操作是否成功
aof_last_write_status:ok|最近一次AOF写入操作是否成功
aof_last_cow_size:0|在最后一次AOF重写操作期间写入时复制分配的字节大小
# Stats|
total_connections_received:7984|服务器已接受的连接请求数量
total_commands_processed:182663|服务器已执行的命令数量
instantaneous_ops_per_sec:0|服务器每秒钟执行的命令数量
total_net_input_bytes:930418676|Redis每秒网络输入的字节数
total_net_output_bytes:20785139033|Redis每秒网络输出的字节数
instantaneous_input_kbps:0.01|瞬间的Redis输入网络流量(kbps)
instantaneous_output_kbps:4.02|瞬间的Redis输出网络流量(kbps)
rejected_connections:0|因连接数达到maxclients上限后，被拒绝的连接个数
sync_full:0|累计Master full sync的次数;如果值比较大，说明常常出现全量复制，就得分析原因，或调整repl-backlog-size
sync_partial_ok:0|累计Master psync成功的次数
sync_partial_err:0|累计Master pysync 出错失败的次数
expired_keys:22110|因为过期而被自动删除的数据库键数量
expired_stale_perc:0.00|
expired_time_cap_reached_count:0|
evicted_keys:0|因内存used_memory达到maxmemory后，每秒被驱逐的key个数
keyspace_hits:120754|查找键命中的次数
keyspace_misses:23100|查找键未命中的次数
pubsub_channels:0|目前被订阅的频道数量
pubsub_patterns:0|目前被订阅的模式数量
latest_fork_usec:832|最近一次fork操作的耗时的微秒数(BGREWRITEAOF,BGSAVE,SYNC等都会触发fork),当并发场景fork耗时过长对服务影响较大
migrate_cached_sockets:0|
slave_expires_tracked_keys:0|
active_defrag_hits:0|
active_defrag_misses:0|
active_defrag_key_hits:0|
active_defrag_key_misses:0|
# Replication|
role:master|当前Redis的主从状态
connected_slaves:0|下面有几个slave
master_replid:0ab49d0b949a305c406df17e44f27bfab032dbf2|
master_replid2:0000000000000000000000000000000000000000|
master_repl_offset:0|master复制的偏移量
second_repl_offset:-1|
repl_backlog_active:0|标志位，master是否开启了repl_backlog,有效地psync(2.8+)
repl_backlog_size:1048576|repl_backlog的长度(repl-backlog-size)，网络环境不稳定的，建议调整大些。(主从之间如何网络延时过大可以调整此参数，避免重复的触发全量同步)
repl_backlog_first_byte_offset:0|repl_backlog中首字节的复制偏移位
repl_backlog_histlen:0|repl_backlog当前使用的字节数
# CPU|
used_cpu_sys:47.054742|Redis进程消耗的sys cpu
used_cpu_user:37.869591|Redis进程消耗的user cpu
used_cpu_sys_children:7.576141|后台进程耗费的系统 CPU
used_cpu_user_children:31.513974|后台进程耗费的用户 CPU
# Cluster|
cluster_enabled:0|
# Keyspace|
db0:keys=588,expires=369,avg_ttl=2022433|keys=29831410    key的总数,expires=0   过期的key的数量,avg_ttl=0平均key过期的时间



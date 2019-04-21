## 安装PHP7.1.0

* 解压PHP ```tar -zxvf php-7.1.0.tar.gz```
* 生成配置文件 ```./configure --prefix=/home/zhoutengfu/code/php7.1.0/ --enable-fpm --enable-debug ```
* 提示没有C编译器，安装GCC ```apt install gcc```
* 安装的过程中提示没有安装libxml2 ```sudo apt-get install libxml2-dev```
* make去安装提示安装make，安装make ```apt install make```
* make install完成安装 ```make install```

### 疑问？
####  1、```./configure```、```make```、 ```make install``` 的作用是什么？

* ```./configure``` 是用来检测的当前平台的目标特征。比如会检测是不是有cc或者GCC，它是一个shell脚本。并且根据当前系统环境生成Makefile文件。
* ```make``` 用来编译和连接，它从```./cofigure``` 命令产生的Makefile文件中读取指令，然后编译。
* ```make insall``` 用来安装，它也从Makefile中读取指令，安装到指定的位置。

#### 2、为什么每次安装都要通过 ```./configure``` 命令来生成Makefile文件，不提前生成好Makefile文件呢

由于安装的操作系统都有一些差异，一套编译好的代码不能同时运行在所有类型的操作系统上。为了坚决这个问题，每次安装都要先根据系统的情况产生Makefile文件，
准确的说是生成适合当前系统的配置文件，以便于后面编译和安装。


### 其他相关知识点

#### 1、make相关命令
* ```make clean``` 消除编译产生的可执行文件及目标文件（object file，*.o）
* ```make distclean``` 除了清楚可执行文件和目标文件外，把configure所产生的Makefile也清除掉



## 一、选择排序

选择排序的还是循环套循环，内部循环找出最小值，然后进行交换位置

#### code
```PHP
function select_sort(&$value=[])
{
    $length = count($value)-1;

    for ($i=0; $i < $length; $i++) {

        $point = $i;// 最小值索引
        //循环找出最小索引
        for ($j=$i+1; $j <= $length; $j++) {
            if ($value[$point] > $value[$j]) {
                $point = $j;
            }
        }
        //数值交换
        $tmp = $value[$i];
        $value[$i] = $value[$point];
        $value[$point] = $tmp;
    }
    return $value;
}
```
------------------------------------
## 二、希尔排序

希尔排序的还是循环套循环，内部循环和该组的后一个值比较，后面一个小进行交换位置

#### code
```PHP
function shell_sort(&$arr=[])
{
    $len = count($arr);
    $k = floor($len/2);
    //循环直到步长小于1停止
    while($k > 0) {
        //循环所有组的排序
        for($i = 0; $i <=$k; $i++) {
            //循环排序好该组的大小
            for($j = $i; $j < $len, ($j + $k) < $len; $j = $j + $k) {
                //比较出最小值，并且赋值到当前位置
                if($arr[$j] > $arr[$j+$k]) {
                    $tmp = $arr[$j+$k];
                    $arr[$j+$k] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        //百度上好多代码是错误，用的是floor，其实是不能用的，会出现排序不完全
        if ($k>1){
            $k = ceil($k/2);
        }else{
            $k = 0;
        }
    }
    return $arr;
}
```
------------------------------------
## 三、冒泡排序

冒泡排序重复地走访过要排序的数列，一次比较两个元素，如果他们的顺序错误就把他们交换过来

#### code
```PHP
function bubble_sort(&$arr=[])
{
    $flag = true; // 标示 排序未完成
    $length = count($value)-1; // 数组长度
    $index = $length; // 最后一次交换的索引位置 初始值为最后一位
    while ($flag) {
        $flag = false; // 假设排序已完成
        for ($i=0; $i < $index; $i++) {
            if ($value[$i] > $value[$i+1]) {
                $flag = true; // 如果还有交换发生 则排序未完成
                $last = $i; // 记录最后一次发生交换的索引位置
                $tmp = $value[$i];
                $value[$i] = $value[$i+1];
                $value[$i+1] = $tmp;
            }
        }
        $index = $last;
    }
    return $value;
}
```
------------------------------------
## 四、快速排序

快速排序使用递归思想，递归将数组的值和第一个值比较大于的丢到一个数组，小于等于的丢到一个数组，直到数组中没有只有一个值以后将其返回，多值的数组再将其合并。

#### code
```PHP
function quick_sort(&$arr=[])
{
    //判断参数是否是一个数组
    if(!is_array($arr)) return false;
    //递归出口:数组长度为1，直接返回数组
    $length=count($arr);
    if($length<=1) return $arr;
    //数组元素有多个,则定义两个空数组
    $left=$right=array();
    //使用for循环进行遍历，把第一个元素当做比较的对象
    for($i=1;$i<$length;$i++)
    {
        //判断当前元素的大小
        if($arr[$i]<$arr[0]){
            $left[]=$arr[$i];
        }else{
            $right[]=$arr[$i];
        }
    }
    //递归调用
    $left=self::quick_sort($left);
    $right=self::quick_sort($right);
    //将所有的结果合并
    return array_merge($left,array($arr[0]),$right);
}
```
------------------------------------
## 五、桶排序

桶排序，个位、十位、百位的顺序，依次进行排序

#### code
```PHP
function bucket_sort(&$arr=[])
{
    // 获取序列值最大位数
    $max = 0;
    foreach ($value as $v) {
        $length = strlen((string)$v);
        if ($length > $max) {
            $max = $length;// 更新
        }
    }
    unset($v);
    $splice = 1;// 取最小位 初始从右往左数第一位
    while ($splice <= $max) {
        // 分配数字到桶中
        for ($i=0; $i < 10; $i++) {
            foreach ($value as $k => $v) {
                $length = strlen((string)$v);
                // 当前位索引位置
                $index = $length-$splice;
                // 不存在该位 则认为为0
                if ($index < 0) {
                    if ($i === 0) {
                        $arr[0][] = $v;
                    }
                    continue;
                }
                if (((string)$v)[$index] === (string)$i) {
                    $arr[$i][] = $v;
                }
            }
            unset($v);
        }
        // 合并桶中数字
        unset($value);
        foreach ($arr as $tmp) {
            foreach ($tmp as $v) {
                $value[] = $v;
            }
        }
        unset($tmp);
        unset($v);
        unset($arr);
        ++$splice;
    }
    return $value;
}
```
------------------------------------
## 六、归并排序

归并排序和快速排序相似，先查分成数组值，然后递归和并，不同点，快速是在拆分的时候就排好序，而归并是在合并的时候排序

#### code
```PHP
function al_merge($arrA,$arrB)
{
    $arrC = array();
    while(count($arrA) && count($arrB)){
        //这里不断的判断哪个值小,就将小的值给到arrC,但是到最后肯定要剩下几个值,
        //不是剩下arrA里面的就是剩下arrB里面的而且这几个有序的值,肯定比arrC里面所有的值都大所以使用
        $arrC[] = $arrA['0'] < $arrB['0'] ? array_shift($arrA) : array_shift($arrB);
    }
    return array_merge($arrC, $arrA, $arrB);
}
//归并排序主程序
function al_merge_sort($arr=[49,38,65,97,76,13,27,49,55,04]){
    $len=count($arr);
    if($len <= 1)
        return $arr;//递归结束条件,到达这步的时候,数组就只剩下一个元素了,也就是分离了数组
    $mid = intval($len/2);//取数组中间
    $left_arr = array_slice($arr, 0, $mid);//拆分数组0-mid这部分给左边left_arr
    $right_arr = array_slice($arr, $mid);//拆分数组mid-末尾这部分给右边right_arr
    $left_arr = self::al_merge_sort($left_arr);//左边拆分完后开始递归合并往上走
    $right_arr = self::al_merge_sort($right_arr);//右边拆分完毕开始递归往上走
    $arr=self::al_merge($left_arr, $right_arr);//合并两个数组,继续递归
    return $arr;
}
```
------------------------------------
## 七、插入排序

插入排序本质就是从头到尾排序，后面的值，直接插入到前面排好序的对应位置

#### code
```PHP
function insert_for($arr=array())
{
    $len = count($arr);
    for($i = 1; $i < $len; $i++) {
        $base = $arr[$i];
        for($j = $i - 1; $j >= 0; $j--) {
            if ($base < $arr[$j]) {
                $arr[$j + 1] = $arr[$j];
                if ($j === 0) {
                    $arr[$j] = $base;
                    break;
                }
                continue;
            }
            $arr[$j + 1] = $base;
            break;
        }
    }
    return $arr;
}
```
------------------------------------

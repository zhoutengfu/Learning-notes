## 一、题目描述：

在一个二维数组中，每一行都按照从左到右递增的顺序排序，每一列都按照从上到下递增的顺序排序。请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。

#### code
```PHP
$array=[   
    [1,2,3,4],
    [5,6,7],
    [8,9]
];

$target=10;
$len=count($array)-1;
$i=0;

while ($len>=0 &&($i<count($array[$len])))
{
    if ($array[$len][$i]>$target)
    {
        $len--;
    }elseif ($target >$array[$len][$i])
    {
        $i++;
    }else{
        return true;
    }
}
return false;
```

------------------------------------

## 二、题目描述：

请实现一个函数，将一个字符串中的空格替换成“%20”。例如，当字符串为We Are Happy.则经过替换之后的字符串为We%20Are%20Happy。

#### code
```PHP
return str_replace(' ','%20',$str);
```
------------------------------------
## 三、题目描述：

把一个数组最开始的若干个元素搬到数组的末尾，我们称之为数组的旋转。 输入一个非递减排序的数组的一个旋转，输出旋转数组的最小元素。 例如数组{3,4,5,1,2}为{1,2,3,4,5}的一个旋转，该数组的最小值为1。 NOTE：给出的所有元素都大于0，若数组大小为0，请返回0。
#### code
```PHP
$count=count($rotateArray);
if ($count==0)
{
    return 0;
}
for ($i=0;$i<$count-1;$i++)
{
    if ($rotateArray[$i]>$rotateArray[$i+1])
    {
        return $rotateArray[$i+1];
    }
}
```
此方法通过牛客的压力测试（在时间复杂度上不是最优）
#### 空间换时间
下面使用二分法实现（在牛客没通过压力测试，可能是空间复杂度超了）

```PHP
if(count($rotateArray)==0)
{
    return 0;
}

$left=0;
$right=count($rotateArray)-1;
$middle=0;
while ($rotateArray[$left]>$rotateArray[$right])
{
    if($right-$left==1){
        $middle = $right;
        break;
    }
    $middle=$left+floor(($right-$left)/2);
    if ($rotateArray[$middle]>=$rotateArray[$left])
    {
        $left = $middle;
    }
    if ($rotateArray[$middle]<=$rotateArray[$right])
    {
        $right = $middle;
    }
}
return $rotateArray[$middle];
```
------------------------------------
## 四、题目描述：

大家都知道斐波那契数列，现在要求输入一个整数n，请你输出斐波那契数列的第n项。
n<=39

#### code
```PHP
function Fibonacci($n)
{
    if ($n<0||$n>39)
    {
        return false;
    }

    $val=[];
    for ($i=0;$i<=$n;$i++)
    {
        if ($i==0)
        {
            $val[$i]=$i;
            continue;
        }elseif ($i==1)
        {
            $val[$i]=$i;
            continue;
        }
        $val[$i]=$val[$i-1]+$val[$i-2];
    }

    return $val[$n];
}
```
------------------------------------


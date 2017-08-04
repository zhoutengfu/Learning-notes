题目描述：

在一个二维数组中，每一行都按照从左到右递增的顺序排序，每一列都按照从上到下递增的顺序排序。请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。

### code
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

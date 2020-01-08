<?php
/*
 *获取最新的博客，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//查询数据库中所有的博客信息
$sql=mysqli_query($conn,"SELECT `date`,`blog`.`phone`,`title`,`content`,`url`,`classification`,`commentName`,`name`,`icon` FROM `blog` INNER JOIN `user` ON `blog`.`phone` = `user`.`phone` ORDER BY `date` DESC");
$result=array();

//从查询到的结果获取一行作为关联数组，并将数据存储到result中
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //返回结果到客户端中   
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
    $back[$i]["date"]=$result[$i]["date"];
    $back[$i]["title"]=$result[$i]["title"];
    $back[$i]["url"]=$result[$i]["url"];
    $back[$i]["content"]=$result[$i]["content"];
    $back[$i]["classification"]=$result[$i]["classification"];
    $back[$i]["comment_name"]=$result[$i]["commentName"];
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
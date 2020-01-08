<?php
/*
 *获取关于博客的评论，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$commentName=$_POST['comment_name'];

//查询数据库中指定博客的评论信息
$sql=mysqli_query($conn,"SELECT `date`,`$commentName`.`phone`,`comment`,`name`,`icon` FROM `$commentName` INNER JOIN `user` ON `$commentName`.`phone` = `user`.`phone` ORDER BY `date` DESC");
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
    $back[$i]["comment"]=$result[$i]["comment"];
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
<?php
/*
 *获取消息列表，服务器进行的处理
 */
include 'utils.php';

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];
$notReadName=$getPhone."null";

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//查询数据库中消息表中的消息信息
$sql=mysqli_query($conn,"SELECT * FROM `$notReadName` INNER JOIN `user` ON `$notReadName`.`associationName` = `user`.`phone` ORDER BY `date` DESC");
$result=array();

//从查询到的结果获取一行作为关联数组
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //返回结果到客户端中   
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
    $back[$i]["status"]=$result[$i]["status"];
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
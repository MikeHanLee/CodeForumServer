<?php
/*
 *获取用户与指定好友的历史消息，服务器进行的处理
 */
include 'utils.php';

// 获取客户端post过来的数据
$getAssociationName=$_POST['association_name'];
$getUserPhone=$_POST['user_phone'];
$getPhone=$_POST['phone'];

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//查询数据库中指定消息列表中的消息信息
$sql=mysqli_query($conn,"SELECT * FROM `$getAssociationName` INNER JOIN `user` ON `$getAssociationName`.`fromClient` = `user`.`phone` ORDER BY `date` ASC");
//消息列表名
$notReadName=$getUserPhone."null";
mysqli_query($conn,"UPDATE `$notReadName` SET `status` = '1' WHERE `associationName` = '$getPhone'");
$result=array();

//从查询到的结果获取一行作为关联数组
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //返回结果到客户端中   
    $back[$i]['text']=$result[$i]['text'];
    $back[$i]['fromClient']=$result[$i]['fromClient'];
    $back[$i]['icon']=base64_encode($result[$i]['icon']);
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
<?php
/*
 *添加好友前获取符合查询条件的用户，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$indexName=$_POST['name'];

//查询数据库中User表中符合查询条件的用户信息
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` REGEXP '$indexName' OR `name` REGEXP '$indexName'");
$result=array();

//从查询到的结果获取一行作为关联数组
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
if(count($result)>0){
for($i=0;$i<count($result);$i++){
    //返回结果到客户端中   
    $back[$i]['status']="1";
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
}
}else{
    //返回结果到客户端中   
    $back[0]['status']="-1";
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
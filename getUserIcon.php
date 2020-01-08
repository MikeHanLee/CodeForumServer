<?php
/*
 *获取用户头像，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];

//查询数据库中User表中用户的信息
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` = '$getPhone'");

//从查询到的结果获取一行作为关联数组
$result=mysqli_fetch_assoc($sql);
if($sql){
    //返回结果到客户端中   
    $back['status']=1;
    $back['info']=base64_encode($result['icon']);
}else{
    //返回结果到客户端中   
    $back['status']=-1;
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
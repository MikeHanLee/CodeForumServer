<?php
/*
 *给指定博客添加评论，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getComment=$_POST['comment'];
$getPhone=$_POST['phone'];
$getCommentName=$_POST['comment_name'];

//设置时区为中国
date_default_timezone_set('PRC');
//设置时间以Y-m-d H:m:s格式显示
$nowTime=date("Y-m-d H:i:s");

//在数据库中执行插入评论信息表操作并返回操作结果
$result=mysqli_query($conn,"INSERT INTO `$getCommentName`(`date`, `phone`, `comment`) VALUES ('$nowTime', '$getPhone', '$getComment')");
if($result){
    //返回结果到客户端中   
    $back['status']="1";
}else{
    //返回结果到客户端中   
    $back['status']="-1";
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
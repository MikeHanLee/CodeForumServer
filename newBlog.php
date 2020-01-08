<?php
/*
 *新建博客，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getTitle=$_POST['title'];
$getPhone=$_POST['phone'];
$getContent=$_POST['content'];
$getUrl=$_POST['url'];
$getClassification=$_POST['classification'];

//设置时区为中国
date_default_timezone_set('PRC');
//设置时间以Y-m-d H:m:s格式显示
$nowTime=date("Y-m-d H:i:s");

//用户博客列表名
$myBlogName=$getPhone."blog";
//博客评论信息表名
$commentName=time();

//在数据库中执行插入博客信息操作和创建博客评论信息表操作并返回操作结果
$result=mysqli_query($conn,"INSERT INTO `blog` (`date`, `phone`, `title`, `content`, `url`, `classification`, `commentName`) VALUES ('$nowTime', '$getPhone', '$getTitle', '$getContent', '$getUrl', '$getClassification', '$commentName')");
$myResult=mysqli_query($conn,"INSERT INTO `$myBlogName` (`date`, `title`, `content`, `url`, `classification`, `commentName`) VALUES ('$nowTime', '$getTitle', '$getContent', '$getUrl', '$getClassification', '$commentName')");
$commentResult=mysqli_query($conn,"CREATE TABLE `$commentName`(`date` DATETIME NOT NULL,`phone` VARCHAR(11) NOT NULL,`comment` TEXT NOT NULL,PRIMARY KEY(`date`))");
if($result&&$myResult&$commentResult){
    //返回结果到客户端中   
    $back['status']="1";
}else if($myResult){
    //返回结果到客户端中   
    $back['status']="-1";
}else if($result){
    //返回结果到客户端中   
    $back['status']="-2";
}else{
    //返回结果到客户端中   
    $back['status']="-3";
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
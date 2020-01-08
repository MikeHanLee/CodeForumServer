<?php
/*
 *用户注册，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getName=$_POST['name'];//客户端post过来的用户名
$getPwd=$_POST['pwd'];//客户端post过来的密码
$getPhone=$_POST['phone'];//客户端post过来的手机号
$getIcon=$_POST['icon'];//客户端post过来的头像
$getIcon=preg_replace("/\n/is", "",$getIcon);
$getIcon=preg_replace("/\s/is", "+",$getIcon);
$getBlob=addslashes(base64_to_blob($getIcon)['blob']);//头像转为Blob存储

//查询数据库中User表中的用户信息
$sqlPhone=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$sqlName=mysqli_query($conn,"SELECT * FROM `user` WHERE `name` ='$getName'");

//从查询到的结果获取一行作为关联数组
$phoneResult=mysqli_fetch_assoc($sqlPhone);
$nameResult=mysqli_fetch_assoc($sqlName);

//如果查询结果不为空，说明用户名和用户手机号均没有注册过，可以执行注册操作
if(!empty($phoneResult)){
    //返回结果到客户端中
    
    //手机号被注册过
    $back['status']="-1";
    $back['info']="cellphone alredy register";
    echo(json_encode($back));
}else if(!empty($nameResult)){
    //返回结果到客户端中   
    
    //用户名手机号被注册过
    $back['status']="-2";
    $back['info']="user name already exit";
    echo(json_encode($back));
}else{    
    //用户消息列表名
    $notReadName=$getPhone."null";
    //用户博客列表名
    $myBlogName=$getPhone."blog";
    
    //在数据库中执行创建用户消息列表、通讯录列表、个人博客列表，插入用户信息到User表和UserInfo表中等操作
    mysqli_query($conn,"CREATE TABLE `$getPhone`(`toClient` VARCHAR(11) NOT NULL,`associationTableName` TEXT NOT NULL,PRIMARY KEY(`toClient`))");
    mysqli_query($conn,"CREATE TABLE `$notReadName`(`date` DATETIME NOT NULL,`associationName` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,PRIMARY KEY(`date`))");
    mysqli_query($conn,"CREATE TABLE `$myBlogName`(`date` DATETIME NOT NULL,`title` TEXT NOT NULL,`content` TEXT NOT NULL,`url` TEXT NOT NULL,`classification` TEXT NOT NULL,`commentName` TEXT NOT NULL,PRIMARY KEY(`date`))");
    mysqli_query($conn,"INSERT INTO `user` (`name`, `pwd`, `phone`, `icon`) VALUES ('$getName', '$getPwd', '$getPhone', '$getBlob')");
    mysqli_query($conn,"INSERT INTO `userInfo` (`phone`, `name`, `birth_date`, `gender`, `hometown`) VALUES ('$getPhone', '$getName', NULL, NULL, NULL)");
    
    //用户
    $path="/var/www/html/CodeForum/uploaded/".$getPhone."/image";
    mkdir(iconv("utf-8", "gbk", $path),0777,true);
    copy("/var/www/html/CodeForum/uploaded/image.jpg", $path."/image.jpg");
    
    //返回结果到客户端中 
    
    //注册成功
    $back['status']="1";
    $back['info']="register successfully";
    echo(json_encode($back));
}

// 关闭数据库连接
mysqli_close($conn);
?>
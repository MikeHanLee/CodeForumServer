<?php
/*
 *获取用户的头像的原始图片，服务器进行的处理
 */
// 获取客户端post过来的数据
$path = $_POST['name'];

//保存图片的路径
$rootPath = '/var/www/html/CodeForum/uploaded/'.$path."/image/";

//获取图片数据
$info = getimagesize($rootPath."image.jpg");
header("Content-Type:".$info['mime']);
//执行下载的文件名
header("Content-Disposition:attachment;filename=image.jpg");
//指定文件大小
header("Content-Length:".filesize($rootPath."image.jpg"));
//响应内容
readfile($rootPath."image.jpg");
?>
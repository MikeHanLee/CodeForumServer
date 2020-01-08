<?php
/*
 *用户头像原始图片上传，服务器进行的处理
 */
// 获取客户端post过来的数据
$getPhone=$_POST['phone'];

//接收文件目录
$targetPath  = "/var/www/html/CodeForum/uploaded/".$getPhone."/image/";
$path="/var/www/html/CodeForum/uploaded/".$getPhone."/image";
if(!is_dir($path)){
    //目录不存在，创建目录
    mkdir(iconv("utf-8", "gbk", $path),0777,true);
}

//$_FILES['img']['name']为接收到的文件的文件名
$targetPath = $targetPath.($_FILES['img']['name']);
$targetPath = iconv("UTF-8","gb2312", $targetPath);
if(move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
    echo "The file ".( $_FILES['img']['name'])." has been uploaded.";
}else{
    echo " --There was an error uploading the file, please try again! Error Code: ".$_FILES['img']['error'];
}
?>
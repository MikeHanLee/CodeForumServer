<?php
/*
 *�½����ͣ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getTitle=$_POST['title'];
$getPhone=$_POST['phone'];
$getContent=$_POST['content'];
$getUrl=$_POST['url'];
$getClassification=$_POST['classification'];

//����ʱ��Ϊ�й�
date_default_timezone_set('PRC');
//����ʱ����Y-m-d H:m:s��ʽ��ʾ
$nowTime=date("Y-m-d H:i:s");

//�û������б���
$myBlogName=$getPhone."blog";
//����������Ϣ����
$commentName=time();

//�����ݿ���ִ�в��벩����Ϣ�����ʹ�������������Ϣ����������ز������
$result=mysqli_query($conn,"INSERT INTO `blog` (`date`, `phone`, `title`, `content`, `url`, `classification`, `commentName`) VALUES ('$nowTime', '$getPhone', '$getTitle', '$getContent', '$getUrl', '$getClassification', '$commentName')");
$myResult=mysqli_query($conn,"INSERT INTO `$myBlogName` (`date`, `title`, `content`, `url`, `classification`, `commentName`) VALUES ('$nowTime', '$getTitle', '$getContent', '$getUrl', '$getClassification', '$commentName')");
$commentResult=mysqli_query($conn,"CREATE TABLE `$commentName`(`date` DATETIME NOT NULL,`phone` VARCHAR(11) NOT NULL,`comment` TEXT NOT NULL,PRIMARY KEY(`date`))");
if($result&&$myResult&$commentResult){
    //���ؽ�����ͻ�����   
    $back['status']="1";
}else if($myResult){
    //���ؽ�����ͻ�����   
    $back['status']="-1";
}else if($result){
    //���ؽ�����ͻ�����   
    $back['status']="-2";
}else{
    //���ؽ�����ͻ�����   
    $back['status']="-3";
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *�û�ע�ᣬ���������еĴ���
 */
include 'utils.php';

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getName=$_POST['name'];//�ͻ���post�������û���
$getPwd=$_POST['pwd'];//�ͻ���post����������
$getPhone=$_POST['phone'];//�ͻ���post�������ֻ���
$getIcon=$_POST['icon'];//�ͻ���post������ͷ��
$getIcon=preg_replace("/\n/is", "",$getIcon);
$getIcon=preg_replace("/\s/is", "+",$getIcon);
$getBlob=addslashes(base64_to_blob($getIcon)['blob']);//ͷ��תΪBlob�洢

//��ѯ���ݿ���User���е��û���Ϣ
$sqlPhone=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$sqlName=mysqli_query($conn,"SELECT * FROM `user` WHERE `name` ='$getName'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$phoneResult=mysqli_fetch_assoc($sqlPhone);
$nameResult=mysqli_fetch_assoc($sqlName);

//�����ѯ�����Ϊ�գ�˵���û������û��ֻ��ž�û��ע���������ִ��ע�����
if(!empty($phoneResult)){
    //���ؽ�����ͻ�����
    
    //�ֻ��ű�ע���
    $back['status']="-1";
    $back['info']="cellphone alredy register";
    echo(json_encode($back));
}else if(!empty($nameResult)){
    //���ؽ�����ͻ�����   
    
    //�û����ֻ��ű�ע���
    $back['status']="-2";
    $back['info']="user name already exit";
    echo(json_encode($back));
}else{    
    //�û���Ϣ�б���
    $notReadName=$getPhone."null";
    //�û������б���
    $myBlogName=$getPhone."blog";
    
    //�����ݿ���ִ�д����û���Ϣ�б�ͨѶ¼�б����˲����б������û���Ϣ��User���UserInfo���еȲ���
    mysqli_query($conn,"CREATE TABLE `$getPhone`(`toClient` VARCHAR(11) NOT NULL,`associationTableName` TEXT NOT NULL,PRIMARY KEY(`toClient`))");
    mysqli_query($conn,"CREATE TABLE `$notReadName`(`date` DATETIME NOT NULL,`associationName` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,PRIMARY KEY(`date`))");
    mysqli_query($conn,"CREATE TABLE `$myBlogName`(`date` DATETIME NOT NULL,`title` TEXT NOT NULL,`content` TEXT NOT NULL,`url` TEXT NOT NULL,`classification` TEXT NOT NULL,`commentName` TEXT NOT NULL,PRIMARY KEY(`date`))");
    mysqli_query($conn,"INSERT INTO `user` (`name`, `pwd`, `phone`, `icon`) VALUES ('$getName', '$getPwd', '$getPhone', '$getBlob')");
    mysqli_query($conn,"INSERT INTO `userInfo` (`phone`, `name`, `birth_date`, `gender`, `hometown`) VALUES ('$getPhone', '$getName', NULL, NULL, NULL)");
    
    //�û�
    $path="/var/www/html/CodeForum/uploaded/".$getPhone."/image";
    mkdir(iconv("utf-8", "gbk", $path),0777,true);
    copy("/var/www/html/CodeForum/uploaded/image.jpg", $path."/image.jpg");
    
    //���ؽ�����ͻ����� 
    
    //ע��ɹ�
    $back['status']="1";
    $back['info']="register successfully";
    echo(json_encode($back));
}

// �ر����ݿ�����
mysqli_close($conn);
?>
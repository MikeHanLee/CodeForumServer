<?php
/*
 *��ָ������������ۣ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getComment=$_POST['comment'];
$getPhone=$_POST['phone'];
$getCommentName=$_POST['comment_name'];

//����ʱ��Ϊ�й�
date_default_timezone_set('PRC');
//����ʱ����Y-m-d H:m:s��ʽ��ʾ
$nowTime=date("Y-m-d H:i:s");

//�����ݿ���ִ�в���������Ϣ����������ز������
$result=mysqli_query($conn,"INSERT INTO `$getCommentName`(`date`, `phone`, `comment`) VALUES ('$nowTime', '$getPhone', '$getComment')");
if($result){
    //���ؽ�����ͻ�����   
    $back['status']="1";
}else{
    //���ؽ�����ͻ�����   
    $back['status']="-1";
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
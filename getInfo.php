<?php
/*
 *��ȡ�û�������Ϣ��¼�����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];//�ͻ���post����������

//��ѯ���ݿ���UserInfo���е��û���Ϣ
$sqlUserInfo=mysqli_query($conn,"SELECT * FROM `userInfo` WHERE `phone` ='$getPhone'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$userInfoResult=mysqli_fetch_assoc($sqlUserInfo);
if(!empty($userInfoResult)){
    //���ؽ�����ͻ�����   
    $back["name"]=$userInfoResult["name"];
    $back["birth_date"]=$userInfoResult["birth_date"];
    $back["gender"]=$userInfoResult["gender"];
    $back["hometown"]=$userInfoResult["hometown"];
    $back["status"]=1;
    echo(json_encode($back));
}else{
    //���ؽ�����ͻ�����   
    $back["status"]=-1;
}

// �ر����ݿ�����
mysqli_close($conn);
?>
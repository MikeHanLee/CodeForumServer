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
$sqlUserInfo=mysqli_query($conn,"SELECT `user`.`phone`,`user`.`name`,`icon`,`birth_date`,`gender`,`hometown`,`friend` FROM `userInfo` INNER JOIN `user` ON `user`.`phone` = `userInfo`.`phone` WHERE `user`.`phone` ='$getPhone'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$userInfoResult=mysqli_fetch_assoc($sqlUserInfo);
if(!empty($userInfoResult)){
    //���ؽ�����ͻ�����   
    $back["name"]=$userInfoResult["name"];
    $back["phone"]=$userInfoResult["phone"];
    $back["icon"]=base64_encode($userInfoResult["icon"]);
    $back["birth_date"]=$userInfoResult["birth_date"];
    $back["gender"]=$userInfoResult["gender"];
    $back["hometown"]=$userInfoResult["hometown"];
    $back["friend"]=$userInfoResult["friend"];
    $back["status"]=1;
    echo(json_encode($back));
}else{
    //���ؽ�����ͻ�����   
    $back["status"]=-1;
}

// �ر����ݿ�����
mysqli_close($conn);
?>
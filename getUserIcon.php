<?php
/*
 *��ȡ�û�ͷ�񣬷��������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];

//��ѯ���ݿ���User�����û�����Ϣ
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` = '$getPhone'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$result=mysqli_fetch_assoc($sql);
if($sql){
    //���ؽ�����ͻ�����   
    $back['status']=1;
    $back['info']=base64_encode($result['icon']);
}else{
    //���ؽ�����ͻ�����   
    $back['status']=-1;
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *��ȡ��Ϣ�б����������еĴ���
 */
include 'utils.php';

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];
$notReadName=$getPhone."null";

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//��ѯ���ݿ�����Ϣ���е���Ϣ��Ϣ
$sql=mysqli_query($conn,"SELECT * FROM `$notReadName` INNER JOIN `user` ON `$notReadName`.`associationName` = `user`.`phone` ORDER BY `date` DESC");
$result=array();

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //���ؽ�����ͻ�����   
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
    $back[$i]["status"]=$result[$i]["status"];
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
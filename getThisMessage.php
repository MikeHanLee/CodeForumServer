<?php
/*
 *��ȡ�û���ָ�����ѵ���ʷ��Ϣ�����������еĴ���
 */
include 'utils.php';

// ��ȡ�ͻ���post����������
$getAssociationName=$_POST['association_name'];
$getUserPhone=$_POST['user_phone'];
$getPhone=$_POST['phone'];

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//��ѯ���ݿ���ָ����Ϣ�б��е���Ϣ��Ϣ
$sql=mysqli_query($conn,"SELECT * FROM `$getAssociationName` INNER JOIN `user` ON `$getAssociationName`.`fromClient` = `user`.`phone` ORDER BY `date` ASC");
//��Ϣ�б���
$notReadName=$getUserPhone."null";
mysqli_query($conn,"UPDATE `$notReadName` SET `status` = '1' WHERE `associationName` = '$getPhone'");
$result=array();

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //���ؽ�����ͻ�����   
    $back[$i]['text']=$result[$i]['text'];
    $back[$i]['fromClient']=$result[$i]['fromClient'];
    $back[$i]['icon']=base64_encode($result[$i]['icon']);
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *��Ӻ���ǰ��ȡ���ϲ�ѯ�������û������������еĴ���
 */
include 'utils.php';

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$indexName=$_POST['name'];

//��ѯ���ݿ���User���з��ϲ�ѯ�������û���Ϣ
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` REGEXP '$indexName' OR `name` REGEXP '$indexName'");
$result=array();

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
if(count($result)>0){
for($i=0;$i<count($result);$i++){
    //���ؽ�����ͻ�����   
    $back[$i]['status']="1";
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
}
}else{
    //���ؽ�����ͻ�����   
    $back[0]['status']="-1";
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
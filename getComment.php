<?php
/*
 *��ȡ���ڲ��͵����ۣ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$commentName=$_POST['comment_name'];

//��ѯ���ݿ���ָ�����͵�������Ϣ
$sql=mysqli_query($conn,"SELECT `date`,`$commentName`.`phone`,`comment`,`name`,`icon` FROM `$commentName` INNER JOIN `user` ON `$commentName`.`phone` = `user`.`phone` ORDER BY `date` DESC");
$result=array();

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ�������飬�������ݴ洢��result��
while($row=mysqli_fetch_array($sql)){
    $result[]=$row;
}
$back=array();
for($i=0;$i<count($result);$i++){
    //���ؽ�����ͻ�����   
    $back[$i]["phone"]=$result[$i]["phone"];
    $back[$i]["name"]=$result[$i]["name"];
    $back[$i]["icon"]=base64_encode($result[$i]["icon"]);
    $back[$i]["date"]=$result[$i]["date"];
    $back[$i]["comment"]=$result[$i]["comment"];
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *��ȡ�û��Ĳ��ͣ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];

//��ѯ���ݿ����û��Ĳ�����Ϣ
$sql=mysqli_query($conn,"SELECT `date`,`blog`.`phone`,`title`,`content`,`url`,`classification`,`commentName`,`name`,`icon` FROM `blog` INNER JOIN `user` ON `blog`.`phone` = `user`.`phone` WHERE `blog`.`phone`='$getPhone' ORDER BY `date` DESC");
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
    $back[$i]["date"]=$result[$i]["date"];
    $back[$i]["title"]=$result[$i]["title"];
    $back[$i]["url"]=$result[$i]["url"];
    $back[$i]["content"]=$result[$i]["content"];
    $back[$i]["classification"]=$result[$i]["classification"];
    $back[$i]["comment_name"]=$result[$i]["commentName"];
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *�û�������Ϣ���ģ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];
$getName=$_POST['name'];
$getBirthDate=$_POST['birth_date'];
$getGender=$_POST['gender'];
$getHometown=$_POST['hometown'];

//�����ݿ���ִ�и����û�������Ϣ�����ؽ��
if($getBirthDate==""){
    $result=mysqli_query($conn,"UPDATE `userInfo` SET `name` = '$getName', `birth_date` = NULL, `gender` = '$getGender', `hometown` = '$getHometown' WHERE `phone` = '$getPhone'");
}else{
    $result=mysqli_query($conn,"UPDATE `userInfo` SET `name` = '$getName', `birth_date` = '$getBirthDate', `gender` = '$getGender', `hometown` = '$getHometown' WHERE `phone` = '$getPhone'");
}
if($result){
    //�����ݿ���ִ�и����û�����
    mysqli_query($conn,"UPDATE `user` SET `name` = '$getName' WHERE `phone` = '$getPhone'");
    
    //���ؽ�����ͻ�����
    
    //���³ɹ�
    $back['status']=1;
}else{
    //���ؽ�����ͻ�����   
    
    //����ʧ��
    $back['status']=-1;
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
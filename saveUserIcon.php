<?php
/*
 *�û�ͷ����Ĳ����棬���������еĴ���
 */
include 'utils.php';

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];
$getIcon=$_POST['icon'];

//����base64��ʽ��ͼƬ����
$getIcon=preg_replace("/\n/is", "",$getIcon);
$getIcon=preg_replace("/\s/is", "+",$getIcon);
//base64��������תΪblog��������
$getBlob=addslashes(base64_to_blob($getIcon)['blob']);

//�����ݿ���ִ�и����û�ͷ�����ݲ����ؽ��
$result=mysqli_query($conn,"UPDATE `user` SET `icon` = '$getBlob' WHERE `phone` = '$getPhone'");
if($result){
    //���ؽ�����ͻ�����   
    
    //���³ɹ�
    $back['status']=1;
    $back['info']=$getIcon;
}else{
    //���ؽ�����ͻ�����   
    
    //����ʧ��
    $back['status']=-1;
    $back['info']=$getIcon;
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
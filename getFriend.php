<?php
/*
 *��ȡ�û��Լ��ĺ��ѣ����������еĴ���
 */
include 'utils.php';

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];//�ͻ���post�������ֻ���

//��ѯ���ݿ���User���е��û���Ϣ
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$result=mysqli_fetch_assoc($sql);
$friendPhone=array();
$back=array();
if(!empty($result)){
    //������еĺ����б�תΪ����
    $friendPhone=explode(",",$result["friend"]);
    for($i=0;$i<count($friendPhone);$i++){
        //��ѯ���ݿ��к��ѵ���Ϣ
        $friendSql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$friendPhone[$i]'");
        
        //�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
        $friendResult=mysqli_fetch_assoc($friendSql);
        
        //���ؽ�����ͻ�����   
        $back[$i]["name"]=$friendResult["name"];
        $back[$i]["phone"]=$friendResult["phone"];
        $back[$i]["icon"]=base64_encode($friendResult["icon"]);
    }
}else{
    //���ؽ�����ͻ�����   
    $back[0]["name"]="";
}
echo(json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
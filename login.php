<?php
/*
 *�û�ͨ�������¼�����������еĴ���
 */
include 'utils.php';

//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// ��ȡ�ͻ���post����������
$getId=$_POST['uid'];//�ͻ���post�������û���
$getPwd=$_POST['pwd'];//�ͻ���post����������
$getPhone=$_POST['uid'];//�ͻ���post�������ֻ���

//��ѯ���ݿ���User���е��û���Ϣ
$sqlPhone=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `name` ='$getId'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$phoneResult=mysqli_fetch_assoc($sqlPhone);
$result=mysqli_fetch_assoc($sql);
if(!empty($result)){
    //���ڸ��û�
    if($getPwd==$result['pwd']){
        //�û�������ƥ����
        $back['status']="1";
        $back['info']="login success";
        $back['name']=$result['name'];
        $back['phone']=$result['phone'];
        $back['icon']=base64_encode($result['icon']);
        echo(json_encode($back));
    }else{/*�������*/
        $back['status']="-2";
        $back['info']="password error";
        echo(json_encode($back));
    }
}else if(!empty($phoneResult)){
    //���ڸ��û�
    if($getPwd==$phoneResult['pwd']){
        //�û�������ƥ����ȷ
        
        //���ؽ�����ͻ�����   
        $back['status']="1";
        $back['info']="login success";
        $back['name']=$phoneResult['name'];
        $back['phone']=$phoneResult['phone'];
        $back['icon']=base64_encode($phoneResult['icon']);
        echo(json_encode($back));
    }else{
        //�������
        
        //���ؽ�����ͻ�����   
        $back['status']="-2";
        $back['info']="password error";
        echo(json_encode($back));
    }
}else{
    //�����ڸ��û�
    
    //���ؽ�����ͻ�����   
    $back['status']="-1";
    $back['info']="user not exist";
    echo(json_encode($back));
}

// �ر����ݿ�����
mysqli_close($conn);
?>
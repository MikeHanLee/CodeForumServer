<?php
/*
 *��Ӻ��ѣ����������еĴ���
 */
//����CodeForum���ݿ�
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("���ݿ���������Ӵ���".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];//��Ӻ��ѵ��ֻ���
$getUserPhone=$_POST['name'];//�û��ֻ���

//��ѯ���ݿ����û�������Ƿ����
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getUserPhone'");
$friendSql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");

//�Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
$result=mysqli_fetch_assoc($sql);
$friendResult=mysqli_fetch_assoc($friendSql);

//�ж�post�����������ֻ����Ƿ���ͬ
if($getPhone!=$getUserPhone){
    $friend="";
    $friendFriend="";
    
    //�ж��û��Ƿ�û�к���
    if($result["friend"]!=null){
        
        //�û��Ѿ�ӵ���������ѣ�������Ӧ����
        
        //�ж��û��Ƿ��Ѿ���ӹ�����
        if(!strstr($result["friend"],$getPhone)){
            
            //��Ӻ��ѣ�ִ����Ӧ�Ĳ���
            $friend=$result["friend"].",".$getPhone;
            
            //�жϺ����Ƿ�û�к���
            if($friendResult["friend"]!=null){
                //�к��ѣ������ַ���ƴ��
                $friendFriend=$friendResult["friend"].",".$getUserPhone;
            }else{
                //û�к��ѣ�ֱ�Ӳ���
                $friendFriend=$getUserPhone;
            }

            //�����û��������Ϣ������
            $tableName=$getPhone<$getUserPhone?$getPhone."_".$getUserPhone:$getUserPhone."_".$getPhone;
            mysqli_query($conn,"CREATE TABLE `$tableName`(`date` DATETIME NOT NULL,`fromClient` TEXT NOT NULL,`text` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,PRIMARY KEY(`date`))");
            
            //�����ѽ�����ı���������Ե�ͨѶ¼��
            mysqli_query($conn,"INSERT INTO `$getPhone` (`toClient`,`associationTableName`) VALUES ('$getUserPhone','$tableName')");
            mysqli_query($conn,"INSERT INTO `$getUserPhone` (`toClient`,`associationTableName`) VALUES ('$getPhone','$tableName')");
            
            //����˫���ĺ����б�
            mysqli_query($conn,"UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
            mysqli_query($conn,"UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");
            
            //���ؽ�����ͻ�����            
            $back["status"]="1";//��Ӻ��ѳɹ�
            $back["info"]="add friend successfully";
        }else{
            //���ؽ�����ͻ�����       
            $back["status"]="-1";//��Ӻ���ʧ�ܣ��Ѿ���ӹ��ú���
            $back["info"]="you already have this friend";
        }
    }else{
        
        //�û�û���κ��������ѣ�������Ӧ����
        
        $friend=$getPhone;
        
        //�жϺ����Ƿ�û�к���
        if($friendResult["friend"]!=null){
            //�к��ѣ������ַ���ƴ��
            $friendFriend=$friendResult["friend"].",".$getUserPhone;
        }else{
            //û�к��ѣ�ֱ�Ӳ���
            $friendFriend=$getUserPhone;
        }
        
        //�����û��������Ϣ������
        $tableName=$getPhone<$getUserPhone?$getPhone."_".$getUserPhone:$getUserPhone."_".$getPhone;
        mysqli_query($conn,"CREATE TABLE `$tableName`(`date` DATETIME NOT NULL,`fromClient` TEXT NOT NULL,`text` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,,PRIMARY KEY(`date`))");
        
        //�����ѽ�����ı���������Ե�ͨѶ¼��
        mysqli_query($conn,"INSERT INTO `$getPhone` (`toClient`,`associationTableName`) VALUES ('$getUserPhone','$tableName')");
        mysqli_query($conn,"INSERT INTO `$getUserPhone` (`toClient`,`associationTableName`) VALUES ('$getPhone','$tableName')");
        
        //����˫���ĺ����б�
        mysqli_query($conn,"UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
        mysqli_query($conn,"UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");
        
        //���ؽ�����ͻ�����       
        $back["status"]="1";//��Ӻ��ѳɹ�
        $back["info"]="add friend successfully";
    }
}else{
    //���ؽ�����ͻ�����       
    $back["status"]="-2";//��Ӻ���ʧ�ܣ���������Լ�Ϊ����
    $back["info"]="this is your own account";
}

echo(json_encode($back));

//�ر����ݿ�����
mysqli_close($conn);
?>
<?php
/*
 *�û�ͷ��ԭʼͼƬ�ϴ������������еĴ���
 */
// ��ȡ�ͻ���post����������
$getPhone=$_POST['phone'];

//�����ļ�Ŀ¼
$targetPath  = "/var/www/html/CodeForum/uploaded/".$getPhone."/image/";
$path="/var/www/html/CodeForum/uploaded/".$getPhone."/image";
if(!is_dir($path)){
    //Ŀ¼�����ڣ�����Ŀ¼
    mkdir(iconv("utf-8", "gbk", $path),0777,true);
}

//$_FILES['img']['name']Ϊ���յ����ļ����ļ���
$targetPath = $targetPath.($_FILES['img']['name']);
$targetPath = iconv("UTF-8","gb2312", $targetPath);
if(move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
    echo "The file ".( $_FILES['img']['name'])." has been uploaded.";
}else{
    echo " --There was an error uploading the file, please try again! Error Code: ".$_FILES['img']['error'];
}
?>
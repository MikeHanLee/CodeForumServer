<?php
/*
 *��ȡ�û���ͷ���ԭʼͼƬ�����������еĴ���
 */
// ��ȡ�ͻ���post����������
$path = $_POST['name'];

//����ͼƬ��·��
$rootPath = '/var/www/html/CodeForum/uploaded/'.$path."/image/";

//��ȡͼƬ����
$info = getimagesize($rootPath."image.jpg");
header("Content-Type:".$info['mime']);
//ִ�����ص��ļ���
header("Content-Disposition:attachment;filename=image.jpg");
//ָ���ļ���С
header("Content-Length:".filesize($rootPath."image.jpg"));
//��Ӧ����
readfile($rootPath."image.jpg");
?>
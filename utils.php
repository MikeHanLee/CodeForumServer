<?php
/*
 *���õ�API
 */

//��ͼƬתΪbase64�������ݴ���
function imgToBase64($img_file) {
    
    $img_base64 = '';
    if (file_exists($img_file)) {
        $app_img_file = $img_file; // ͼƬ·��
        $img_info = getimagesize($app_img_file); // ȡ��ͼƬ�Ĵ�С�����͵�
        
        $fp = fopen($app_img_file, "r"); // ͼƬ�Ƿ�ɶ�Ȩ��
        
        if ($fp) {
            $filesize = filesize($app_img_file);
            $content = fread($fp, $filesize);
            $file_content = chunk_split(base64_encode($content)); // base64����
            switch ($img_info[2]) {           //�ж�ͼƬ����
                case 1: $img_type = "gif";
                break;
                case 2: $img_type = "jpg";
                break;
                case 3: $img_type = "png";
                break;
            }
            
            $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content;//�ϳ�ͼƬ��base64����
            
        }
        fclose($fp);
    }
    
    return $img_base64; //����ͼƬ��base64
}

//��base64���͵�����תΪblog�������ݴ��������ݿ���
function base64_to_blob($base64Str){
        return ['blob'=>base64_decode($base64Str),'type'=>'image/jpg'];
}

//�ж��Ƿ�Ϊbase64��������
function is_base64($str){
    if($str === base64_encode(base64_decode($str))){
        return true;
    }
    return false;
}
?>
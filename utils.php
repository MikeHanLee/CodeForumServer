<?php
/*
 *常用的API
 */

//将图片转为base64类型数据储存
function imgToBase64($img_file) {
    
    $img_base64 = '';
    if (file_exists($img_file)) {
        $app_img_file = $img_file; // 图片路径
        $img_info = getimagesize($app_img_file); // 取得图片的大小，类型等
        
        $fp = fopen($app_img_file, "r"); // 图片是否可读权限
        
        if ($fp) {
            $filesize = filesize($app_img_file);
            $content = fread($fp, $filesize);
            $file_content = chunk_split(base64_encode($content)); // base64编码
            switch ($img_info[2]) {           //判读图片类型
                case 1: $img_type = "gif";
                break;
                case 2: $img_type = "jpg";
                break;
                case 3: $img_type = "png";
                break;
            }
            
            $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content;//合成图片的base64编码
            
        }
        fclose($fp);
    }
    
    return $img_base64; //返回图片的base64
}

//将base64类型的数据转为blog类型数据储存至数据库中
function base64_to_blob($base64Str){
        return ['blob'=>base64_decode($base64Str),'type'=>'image/jpg'];
}

//判断是否为base64类型数据
function is_base64($str){
    if($str === base64_encode(base64_decode($str))){
        return true;
    }
    return false;
}
?>
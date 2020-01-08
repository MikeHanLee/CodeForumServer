<?php
/*
 *用户头像更改并保存，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];
$getIcon=$_POST['icon'];

//处理base64格式的图片数据
$getIcon=preg_replace("/\n/is", "",$getIcon);
$getIcon=preg_replace("/\s/is", "+",$getIcon);
//base64类型数据转为blog类型数据
$getBlob=addslashes(base64_to_blob($getIcon)['blob']);

//在数据库中执行更新用户头像数据并返回结果
$result=mysqli_query($conn,"UPDATE `user` SET `icon` = '$getBlob' WHERE `phone` = '$getPhone'");
if($result){
    //返回结果到客户端中   
    
    //更新成功
    $back['status']=1;
    $back['info']=$getIcon;
}else{
    //返回结果到客户端中   
    
    //更新失败
    $back['status']=-1;
    $back['info']=$getIcon;
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
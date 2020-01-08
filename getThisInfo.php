<?php
/*
 *获取用户个人信息登录，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];//客户端post过来的密码

//查询数据库中UserInfo表中的用户信息
$sqlUserInfo=mysqli_query($conn,"SELECT `user`.`phone`,`user`.`name`,`icon`,`birth_date`,`gender`,`hometown`,`friend` FROM `userInfo` INNER JOIN `user` ON `user`.`phone` = `userInfo`.`phone` WHERE `user`.`phone` ='$getPhone'");

//从查询到的结果获取一行作为关联数组
$userInfoResult=mysqli_fetch_assoc($sqlUserInfo);
if(!empty($userInfoResult)){
    //返回结果到客户端中   
    $back["name"]=$userInfoResult["name"];
    $back["phone"]=$userInfoResult["phone"];
    $back["icon"]=base64_encode($userInfoResult["icon"]);
    $back["birth_date"]=$userInfoResult["birth_date"];
    $back["gender"]=$userInfoResult["gender"];
    $back["hometown"]=$userInfoResult["hometown"];
    $back["friend"]=$userInfoResult["friend"];
    $back["status"]=1;
    echo(json_encode($back));
}else{
    //返回结果到客户端中   
    $back["status"]=-1;
}

// 关闭数据库连接
mysqli_close($conn);
?>
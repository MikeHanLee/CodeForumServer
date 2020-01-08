<?php
/*
 *用户通过密码登录，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getId=$_POST['uid'];//客户端post过来的用户名
$getPwd=$_POST['pwd'];//客户端post过来的密码
$getPhone=$_POST['uid'];//客户端post过来的手机号

//查询数据库中User表中的用户信息
$sqlPhone=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `name` ='$getId'");

//从查询到的结果获取一行作为关联数组
$phoneResult=mysqli_fetch_assoc($sqlPhone);
$result=mysqli_fetch_assoc($sql);
if(!empty($result)){
    //存在该用户
    if($getPwd==$result['pwd']){
        //用户名密码匹配正
        $back['status']="1";
        $back['info']="login success";
        $back['name']=$result['name'];
        $back['phone']=$result['phone'];
        $back['icon']=base64_encode($result['icon']);
        echo(json_encode($back));
    }else{/*密码错误*/
        $back['status']="-2";
        $back['info']="password error";
        echo(json_encode($back));
    }
}else if(!empty($phoneResult)){
    //存在该用户
    if($getPwd==$phoneResult['pwd']){
        //用户名密码匹配正确
        
        //返回结果到客户端中   
        $back['status']="1";
        $back['info']="login success";
        $back['name']=$phoneResult['name'];
        $back['phone']=$phoneResult['phone'];
        $back['icon']=base64_encode($phoneResult['icon']);
        echo(json_encode($back));
    }else{
        //密码错误
        
        //返回结果到客户端中   
        $back['status']="-2";
        $back['info']="password error";
        echo(json_encode($back));
    }
}else{
    //不存在该用户
    
    //返回结果到客户端中   
    $back['status']="-1";
    $back['info']="user not exist";
    echo(json_encode($back));
}

// 关闭数据库连接
mysqli_close($conn);
?>
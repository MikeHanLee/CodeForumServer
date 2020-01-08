<?php
/*
 *获取好友头像，服务器进行的处理
 */
include 'utils.php';

//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];//客户端post过来的手机号

//查询数据库中User表中的用户信息
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");

//从查询到的结果获取一行作为关联数组
$result=mysqli_fetch_assoc($sql);
$friendPhone=array();
$back=array();
if(!empty($result)){
    $friendPhone=explode(",",$result["friend"]);
    for($i=0;$i<count($friendPhone);$i++){
        //查询数据库中好友的信息
        $friendSql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$friendPhone[$i]'");
        
        //从查询到的结果获取一行作为关联数组
        $friendResult=mysqli_fetch_assoc($friendSql);
        
        //返回结果到客户端中   
        $back[$i]["name"]=$friendResult["name"];
        $back[$i]["phone"]=$friendResult["phone"];
        $back[$i]["icon"]=base64_encode($friendResult["icon"]);
    }
}else{
    //返回结果到客户端中   
    $back[0]["name"]="";
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
<?php
/*
 *用户个人信息更改，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

// 获取客户端post过来的数据
$getPhone=$_POST['phone'];
$getName=$_POST['name'];
$getBirthDate=$_POST['birth_date'];
$getGender=$_POST['gender'];
$getHometown=$_POST['hometown'];

//在数据库中执行更新用户个人信息并返回结果
if($getBirthDate==""){
    $result=mysqli_query($conn,"UPDATE `userInfo` SET `name` = '$getName', `birth_date` = NULL, `gender` = '$getGender', `hometown` = '$getHometown' WHERE `phone` = '$getPhone'");
}else{
    $result=mysqli_query($conn,"UPDATE `userInfo` SET `name` = '$getName', `birth_date` = '$getBirthDate', `gender` = '$getGender', `hometown` = '$getHometown' WHERE `phone` = '$getPhone'");
}
if($result){
    //在数据库中执行更新用户姓名
    mysqli_query($conn,"UPDATE `user` SET `name` = '$getName' WHERE `phone` = '$getPhone'");
    
    //返回结果到客户端中
    
    //更新成功
    $back['status']=1;
}else{
    //返回结果到客户端中   
    
    //更新失败
    $back['status']=-1;
}
echo(json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
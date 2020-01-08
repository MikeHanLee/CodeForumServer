<?php
/*
 * 用户通过手机短信登录，服务器进行的处理
 */
// 连接CodeForum数据库
$conn = mysqli_connect("127.0.0.1", "root", "19981026") or die("数据库服务器连接错误" . mysqli_error());
mysqli_select_db($conn, "CodeForum");

// 获取客户端post过来的数据
$getPhone = $_POST['phone']; // 用户手机号

// 查询数据库中用户是否存在
$sql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$result = mysqli_fetch_assoc($sql);

// 判断用户是否存在
if (! empty($result)) {
    // 存在该用户
    $back['status'] = "1";
    $back['info'] = "login success";
    $back['name'] = $result['name'];
    $back['phone'] = $result['phone'];
    $back['icon'] = base64_encode($result['icon']);

    // 返回登录成功信息
    echo (json_encode($back));
} else {
    // 不存在该用户
    $back['status'] = "-1";
    $back['info'] = "user not exist";
    // 返回登录失败信息
    echo (json_encode($back));
}

// 关闭数据库连接
mysqli_close($conn);
?>
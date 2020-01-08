<?php
/*
 * 删除好友，服务器进行的处理
 */
// 连接CodeForum数据库
$conn = mysqli_connect("127.0.0.1", "root", "19981026") or die("数据库服务器连接错误" . mysqli_error());
mysqli_select_db($conn, "CodeForum");

// 获取客户端post过来的数据
$getPhone = $_POST['phone']; // 所要删除的好友的手机号
$getUserPhone = $_POST['user_phone']; // 用户手机号

// 查询数据库中用户与好友是否存在
$sql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getUserPhone'");
$friendSql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getPhone'");

// 从查询到的结果获取一行作为关联数组
$result = mysqli_fetch_assoc($sql);
$friendResult = mysqli_fetch_assoc($friendSql);

$friend = "";
$friendFriend = "";
if (strstr($result["friend"], "," . $getPhone)) {
    $friend = str_replace("," . $getPhone, "", $result["friend"]);
} else if (strstr($result["friend"], $getPhone . ",")) {
    $friend = str_replace($getPhone . ",", "", $result["friend"]);
} else {
    $friend = str_replace($getPhone, "", $result["friend"]);
}
if (strstr($friendResult["friend"], "," . $getUserPhone)) {
    $friendFriend = str_replace("," . $getUserPhone, "", $friendResult["friend"]);
} else if (strstr($friendResult["friend"], $getUserPhone . ",")) {
    $friendFriend = str_replace($getUserPhone . ",", "", $friendResult["friend"]);
} else {
    $friendFriend = str_replace($getUserPhone, "", $friendResult["friend"]);
}
// 删除用户与好友消息交流表
$tableName = $getPhone < $getUserPhone ? $getPhone . "_" . $getUserPhone : $getUserPhone . "_" . $getPhone;
mysqli_query($conn, "DROP TABLE `$tableName`");

// 删除各自的通讯录中好友交流表的表名
mysqli_query($conn, "DELETE FROM `$getPhone` WHERE `toClient`='$getUserPhone'");
mysqli_query($conn, "DELETE FROM `$getUserPhone` WHERE `toClient`='$getPhone'");

// 更新双方的好友列表
mysqli_query($conn, "UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
mysqli_query($conn, "UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");

// 返回结果到客户端中
$back["status"] = "1"; // 删除好友成功
$back["friend"]=$friendFriend;
$back["info"] = "add friend successfully";
echo (json_encode($back));

// 关闭数据库连接
mysqli_close($conn);
?>
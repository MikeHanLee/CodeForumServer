<?php
/*
 * ɾ�����ѣ����������еĴ���
 */
// ����CodeForum���ݿ�
$conn = mysqli_connect("127.0.0.1", "root", "19981026") or die("���ݿ���������Ӵ���" . mysqli_error());
mysqli_select_db($conn, "CodeForum");

// ��ȡ�ͻ���post����������
$getPhone = $_POST['phone']; // ��Ҫɾ���ĺ��ѵ��ֻ���
$getUserPhone = $_POST['user_phone']; // �û��ֻ���

// ��ѯ���ݿ����û�������Ƿ����
$sql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getUserPhone'");
$friendSql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getPhone'");

// �Ӳ�ѯ���Ľ����ȡһ����Ϊ��������
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
// ɾ���û��������Ϣ������
$tableName = $getPhone < $getUserPhone ? $getPhone . "_" . $getUserPhone : $getUserPhone . "_" . $getPhone;
mysqli_query($conn, "DROP TABLE `$tableName`");

// ɾ�����Ե�ͨѶ¼�к��ѽ�����ı���
mysqli_query($conn, "DELETE FROM `$getPhone` WHERE `toClient`='$getUserPhone'");
mysqli_query($conn, "DELETE FROM `$getUserPhone` WHERE `toClient`='$getPhone'");

// ����˫���ĺ����б�
mysqli_query($conn, "UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
mysqli_query($conn, "UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");

// ���ؽ�����ͻ�����
$back["status"] = "1"; // ɾ�����ѳɹ�
$back["friend"]=$friendFriend;
$back["info"] = "add friend successfully";
echo (json_encode($back));

// �ر����ݿ�����
mysqli_close($conn);
?>
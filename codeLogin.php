<?php
/*
 * �û�ͨ���ֻ����ŵ�¼�����������еĴ���
 */
// ����CodeForum���ݿ�
$conn = mysqli_connect("127.0.0.1", "root", "19981026") or die("���ݿ���������Ӵ���" . mysqli_error());
mysqli_select_db($conn, "CodeForum");

// ��ȡ�ͻ���post����������
$getPhone = $_POST['phone']; // �û��ֻ���

// ��ѯ���ݿ����û��Ƿ����
$sql = mysqli_query($conn, "SELECT * FROM `user` WHERE `phone` ='$getPhone'");
$result = mysqli_fetch_assoc($sql);

// �ж��û��Ƿ����
if (! empty($result)) {
    // ���ڸ��û�
    $back['status'] = "1";
    $back['info'] = "login success";
    $back['name'] = $result['name'];
    $back['phone'] = $result['phone'];
    $back['icon'] = base64_encode($result['icon']);

    // ���ص�¼�ɹ���Ϣ
    echo (json_encode($back));
} else {
    // �����ڸ��û�
    $back['status'] = "-1";
    $back['info'] = "user not exist";
    // ���ص�¼ʧ����Ϣ
    echo (json_encode($back));
}

// �ر����ݿ�����
mysqli_close($conn);
?>
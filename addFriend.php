<?php
/*
 *添加好友，服务器进行的处理
 */
//连接CodeForum数据库
$conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
mysqli_select_db($conn,"CodeForum");

//获取客户端post过来的数据
$getPhone=$_POST['phone'];//添加好友的手机号
$getUserPhone=$_POST['name'];//用户手机号

//查询数据库中用户与好友是否存在
$sql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getUserPhone'");
$friendSql=mysqli_query($conn,"SELECT * FROM `user` WHERE `phone` ='$getPhone'");

//从查询到的结果获取一行作为关联数组
$result=mysqli_fetch_assoc($sql);
$friendResult=mysqli_fetch_assoc($friendSql);

//判断post过来的两个手机号是否相同
if($getPhone!=$getUserPhone){
    $friend="";
    $friendFriend="";
    
    //判断用户是否没有好友
    if($result["friend"]!=null){
        
        //用户已经拥有其他好友，进行相应操作
        
        //判断用户是否已经添加过好友
        if(!strstr($result["friend"],$getPhone)){
            
            //添加好友，执行相应的操作
            $friend=$result["friend"].",".$getPhone;
            
            //判断好友是否没有好友
            if($friendResult["friend"]!=null){
                //有好友，进行字符串拼接
                $friendFriend=$friendResult["friend"].",".$getUserPhone;
            }else{
                //没有好友，直接插入
                $friendFriend=$getUserPhone;
            }

            //创建用户与好友消息交流表
            $tableName=$getPhone<$getUserPhone?$getPhone."_".$getUserPhone:$getUserPhone."_".$getPhone;
            mysqli_query($conn,"CREATE TABLE `$tableName`(`date` DATETIME NOT NULL,`fromClient` TEXT NOT NULL,`text` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,PRIMARY KEY(`date`))");
            
            //将好友交流表的表名插入各自的通讯录中
            mysqli_query($conn,"INSERT INTO `$getPhone` (`toClient`,`associationTableName`) VALUES ('$getUserPhone','$tableName')");
            mysqli_query($conn,"INSERT INTO `$getUserPhone` (`toClient`,`associationTableName`) VALUES ('$getPhone','$tableName')");
            
            //更新双方的好友列表
            mysqli_query($conn,"UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
            mysqli_query($conn,"UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");
            
            //返回结果到客户端中            
            $back["status"]="1";//添加好友成功
            $back["info"]="add friend successfully";
        }else{
            //返回结果到客户端中       
            $back["status"]="-1";//添加好友失败，已经添加过该好友
            $back["info"]="you already have this friend";
        }
    }else{
        
        //用户没有任何其他好友，进行相应操作
        
        $friend=$getPhone;
        
        //判断好友是否没有好友
        if($friendResult["friend"]!=null){
            //有好友，进行字符串拼接
            $friendFriend=$friendResult["friend"].",".$getUserPhone;
        }else{
            //没有好友，直接插入
            $friendFriend=$getUserPhone;
        }
        
        //创建用户与好友消息交流表
        $tableName=$getPhone<$getUserPhone?$getPhone."_".$getUserPhone:$getUserPhone."_".$getPhone;
        mysqli_query($conn,"CREATE TABLE `$tableName`(`date` DATETIME NOT NULL,`fromClient` TEXT NOT NULL,`text` TEXT NOT NULL,`status` TINYINT(1) NOT NULL,,PRIMARY KEY(`date`))");
        
        //将好友交流表的表名插入各自的通讯录中
        mysqli_query($conn,"INSERT INTO `$getPhone` (`toClient`,`associationTableName`) VALUES ('$getUserPhone','$tableName')");
        mysqli_query($conn,"INSERT INTO `$getUserPhone` (`toClient`,`associationTableName`) VALUES ('$getPhone','$tableName')");
        
        //更新双方的好友列表
        mysqli_query($conn,"UPDATE `user` SET `friend`='$friend' WHERE `phone` ='$getUserPhone'");
        mysqli_query($conn,"UPDATE `user` SET `friend`='$friendFriend' WHERE `phone` ='$getPhone'");
        
        //返回结果到客户端中       
        $back["status"]="1";//添加好友成功
        $back["info"]="add friend successfully";
    }
}else{
    //返回结果到客户端中       
    $back["status"]="-2";//添加好友失败，不能添加自己为好友
    $back["info"]="this is your own account";
}

echo(json_encode($back));

//关闭数据库连接
mysqli_close($conn);
?>
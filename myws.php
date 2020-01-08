<?php
/*
 *通过websocket应用层协议实现客户端和服务器端双向通信
 */
    
    $server = new swoole_websocket_server("0.0.0.0",9200);
    
    $server->on('open',function(swoole_websocket_server $server,$request){
        echo "server: handshake success with fd{$request->fd}\n";
    });
    
    $server->on('message',function(swoole_websocket_server $server,$frame){
        if(strstr($frame->data,"&")){
            $str=explode("&",$frame->data);
        
            $conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
            mysqli_select_db($conn,"CodeForum");
        
            $targetSql=mysqli_query($conn,"SELECT * FROM `ClientId` WHERE `phone` ='$str[2]'");
            $sqlFrom=mysqli_query($conn,"SELECT * FROM `$str[0]` WHERE `toClient` ='$str[2]'");
            $fromResult=mysqli_fetch_assoc($sqlFrom);
            $tableName=$fromResult["associationTableName"];
            date_default_timezone_set('PRC');
            $nowTime=date("Y-m-d H:i:s");
            $notReadName=$str[2]."null";
            $targetResult=mysqli_fetch_assoc($targetSql);
            if($targetResult!=null){
                $notReadSql=mysqli_query($conn,"SELECT * FROM `$notReadName` WHERE `associationName`='$str[0]'");
                $notReadResult=mysqli_fetch_assoc($notReadSql);
                if($notReadResult==null){
                    mysqli_query($conn,"INSERT INTO `$notReadName` (`date`,`associationName`,`status`) VALUES ('$nowTime','$str[0]',0)");
                }else{
                    mysqli_query($conn,"UPDATE `$notReadName` SET `date` = '$nowTime' WHERE `associationName`='$str[0]'");
                }             
                mysqli_query($conn,"INSERT INTO `$tableName` (`date`,`fromClient`,`text`,`status`) VALUES ('$nowTime','$str[0]','$str[1]',0)");
                $server->push($targetResult["clientId"],$frame->data);
            }else{
                $notReadSql=mysqli_query($conn,"SELECT * FROM `$notReadName` WHERE `associationName`='$str[0]'");
                $notReadResult=mysqli_fetch_assoc($notReadSql);
                if($notReadResult==null){
                    mysqli_query($conn,"INSERT INTO `$notReadName` (`date`,`associationName`,`status`) VALUES ('$nowTime','$str[0]',0)");
                }else{
                    mysqli_query($conn,"UPDATE `$notReadName` SET `date` = '$nowTime' WHERE `associationName`='$str[0]'");
                }
                mysqli_query($conn,"INSERT INTO `$tableName` (`date`,`fromClient`,`text`,`status`) VALUES ('$nowTime','$str[0]','$str[1]',0)");
            }
        
            echo "receive from {$str[0]}:{$str[1]}\n";
            echo "to{$str[2]}\n";
            echo "opcode:{$frame->opcode}";
            echo "fin: {$frame->finish}\n";
        
            mysqli_close($conn);
        }else{
            $conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
            mysqli_select_db($conn,"CodeForum");
            $targetSql=mysqli_query($conn,"SELECT * FROM `ClientId` WHERE `phone` ='$frame->data'");
            $targetResult=mysqli_fetch_assoc($targetSql);
            if($targetResult==null){
                mysqli_query($conn,"INSERT INTO `ClientId` (`phone`, `clientId`, `clientStatus`) VALUES ($frame->data, $frame->fd, 0)");
            }else{
                mysqli_query($conn,"UPDATE `ClientId` SET `clientId` = '$frame->fd' WHERE `phone` = '$frame->data'");
            }
            mysqli_close($conn);
        }
    });
        
    $server->on('close',function($ser,$fd){
        $conn=mysqli_connect("127.0.0.1","root","19981026") or die("数据库服务器连接错误".mysqli_error());
        mysqli_select_db($conn,"CodeForum");
        mysqli_query($conn,"DELETE FROM `ClientId` where `clientId`='$fd'");
        mysqli_close($conn);
        echo "client {$fd} closed\n";
    });
    $server->start();
?>
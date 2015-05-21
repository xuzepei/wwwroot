<?php 

//设备令牌
//对应要发送到的手机设备
$deviceToken = "e4d4bdceec86fe6a1189202ec37ccbfd6e7ee75d08913861b67d23e8b86268b1";

//发送的消息体，alert:发送的文字 badge:显示的数字 sound：播放的声音
$body = array("aps" => array("alert" => 'message HiHiHi', "badge" => 1, "sound" => 'received5.caf'));

$ctx = stream_context_create(); 
//设置证书
stream_context_set_option($ctx, "ssl", "local_cert", "ck_pro.pem");

$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT,
$ctx); 

if (!$fp) 
{ print "Failed to connect $err $errstrn"; return; } 

print "Connection OK\n"; 

$payload =json_encode($body); 
$msg = chr(0) . pack("n",32) . pack("H*", $deviceToken) . pack("n",strlen($payload)) .
$payload; 
print "sending message :" . $payload . "\n"; 
fwrite($fp, $msg); 
fclose($fp); 
?>
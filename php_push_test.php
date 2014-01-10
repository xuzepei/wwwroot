<?php 

//设备令牌
//对应要发送到的手机设备
$deviceToken = "6af865cc93966e8ede80d2d5deab4d1e1b72cdb5fec2fbf0909f73576ae5a346";

//发送的消息体，alert:发送的文字 badge:显示的数字 sound：播放的声音
$body = array("aps" => array("alert" => 'message', "badge" => 1, "sound" => 'received5.caf'));

$ctx = stream_context_create(); 
//设置证书
stream_context_set_option($ctx, "ssl", "local_cert", "ck.pem");

$fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT,
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
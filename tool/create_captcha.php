<?php
require_once '../config.php';

session_start();

function random($len)
{
    $temp = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max_index = strlen($temp) - 1;
    mt_srand();
    $str = "";
    for ($i = 0; $i < $len; $i++)
    {
        $str.=$temp[mt_rand(0, $max_index)];
    }
    return $str;
}

$str = random(4); //随机生成的字符串
$width = 100; //验证码图片的宽度 
$height = 36; //验证码图片的高度 

@header("Content-Type:image/png");

//创建图片
$im = imagecreate($width, $height);

//设置图片背景色 
$bg_color = imagecolorallocate($im, 255, 255, 255);


//字符颜色 
$text_color = imagecolorallocate($im, 41, 163, 238);

//边框颜色
$border_color = imagecolorallocate($im, 41, 163, 238);

//干扰线,需要放在模糊点前面先画
mt_srand();
for($i=0; $i < 3; $i++)
{
    $line_color = imagecolorallocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
    imageline($im,mt_rand(0,$width/4.0),mt_rand(0,$height),mt_rand($width/2.0,$width),mt_rand(0,$height),$line_color);
}

//画模糊点 
for ($i = 0; $i < 200; $i++)
{
    //模糊点颜色 
    $pixel_color = imagecolorallocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
    imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pixel_color);
}

//将验证码保存到SESSION，以便对比
$_SESSION["captcha"] = $str;

//画字符
//imagestring($im, 10, 10, 10, $str, $text_color); //不能修改字体大小
$font = BASE_PATH.'/fonts/arial.ttf';
$offset_x = 10;
for($i=0;$i<strlen($str);$i++)
{
    $text_color = imagecolorallocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
    imagettftext($im, 16, 0, $offset_x, 26, $text_color, $font, $str[$i]);
    $offset_x += 20;
}
        
imagerectangle($im, 0, 0, $width - 1, $height - 1, $border_color);
imagepng($im);
imagedestroy($im);

?>

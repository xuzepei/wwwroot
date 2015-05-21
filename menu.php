<?php
    
    require_once './tool/Curl.class.php';

    $token = 'szd6x4e-O24vceF9lYbDC7nQ4fbnVQ04LRPruXKdYcVsp8bvxjKo2GTWpB4f4Qjf7ljXnodEMl3xOGSQUHhbqPT5SunnLpGg-BTiJpCP0Wb5skLd6Ryvt_Z9i7Oc5Xnx40Km1svl-E9tcYLtyB9THQ';
    $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
    
    //主菜单一
    $sub_button0 = array('type'=>'click',
        'name'=>urlencode('关于渔火'),
        'key'=>urlencode('关于渔火'));
    $sub_button1 = array('type'=>'click',
        'name'=>urlencode('渔火环境'),
        'key'=>urlencode('渔火环境'));
    $sub_button2 = array('type'=>'click',
        'name'=>urlencode('烤鱼菜品'),
        'key'=>urlencode('烤鱼菜品'));
    $sub_button3 = array('type'=>'click',
        'name'=>urlencode('门店地址'),
        'key'=>urlencode('门店地址'));
    $main_menu0 = array('type'=>'click',
        'name'=>urlencode('渔火故事'),
        'key'=>urlencode('渔火故事'),
        'sub_button'=>array($sub_button0,$sub_button1,$sub_button2,$sub_button3));
    
    //主菜单二
    $sub_button0 = array('type'=>'click',
        'name'=>urlencode('优惠券'),
        'key'=>urlencode('优惠券'));
    $main_menu1 = array('type'=>'click',
        'name'=>urlencode('优惠促销'),
        'key'=>urlencode('优惠促销'),
        'sub_button'=>array($sub_button0));
    
    //主菜单三
    $sub_button0 = array('type'=>'click',
        'name'=>urlencode('会员注册'),
        'key'=>urlencode('会员'));
    $sub_button1 = array('type'=>'click',
        'name'=>urlencode('积分查询'),
        'key'=>urlencode('积分查询'));
    $main_menu2 = array('type'=>'click',
        'name'=>urlencode('会员专区'),
        'key'=>urlencode('会员专区'),
        'sub_button'=>array($sub_button0,$sub_button1));
    
    $data = array('button'=>array($main_menu0,$main_menu1,$main_menu2));
    
    $data = urldecode(json_encode($data)); 

    echo $data;

    $curl = new Curl();
    $curl->post($url,$data);
    
    if ($curl->error) {
    echo var_dump($curl->error_code);
}
else {
    echo var_dump($curl->response);
}

?>
<?php

/* 可用参数说明
 * ?id= //根据id查询记录
 * ?page=&count=  //page从1开始计数,count为每页显示得条数
 */


require_once '../config.php'; //注意配置文件路径
require_once BASE_PATH.'/db/medoo.php';
$database = new medoo('gongzhang_db');


$designer_id = $_GET["id"];

$page = $_GET["page"];
$count = $_GET["count"];
if(!isset($count) || $count < 0)
    $count = PAGE_SIZE;


$result = '';
$tb_name = 'designer_tb';

//$sum = $database->count('select count(*) from '.$tb_name);

if (isset($designer_id)) {
    $result = $database->select_by_sql('select * from '.$tb_name.' limit 1');
} else if(isset($page)) {
    
    $from_index = ($page - 1)*$count;
    if($from_index < 0)
        $from_index = 0;
    $result = $database->select_by_sql('select * from '.$tb_name.' limit '.$from_index.','.$count);
} else {
    $result = $database->select($tb_name, "*");
}

foreach ($result as &$designer) {
    $designer_id = $designer["id"];
    $works = $database->select("work_tb", "*", [
        "designer_id" => $designer_id
            ]);

    foreach ($works as &$work) {
        $work_id = $work["id"];
        $images = $database->select("image_tb", "*", [
            "work_id" => $work_id
                ]);
        $work['images'] = $images;
    }

    if (count($works, 0)) {
        $designer["works"] = $works;
    }
}

$data = array("data" => $result);
echo json_encode($data);
?>

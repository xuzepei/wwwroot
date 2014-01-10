<?php

require_once '../db/medoo.php';
$database = new medoo('gongzhang_db');

$designer_id = $_GET["id"];
$result = '';
if (isset($designer_id)) {
    $result = $database->select("designer_tb", "*", ["id" => $designer_id]);
} else {
    $result = $database->select("designer_tb", "*");
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

$data = array("list" => $result);
echo json_encode($data);
?>

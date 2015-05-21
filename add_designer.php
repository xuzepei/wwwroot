<!DOCTYPE html>

<?php
include_once("mvc/controller/DesignerController.php");

$title = "添加设计师";
$header = $title;

$css_file_array = array('./bootstrap/v2/css/bootstrap.min.css',
        './bootstrap/v2/css/bootstrap-responsive.min.css',
        './css/add_designer.css',
);

$js_file_array = array(
    "./js/add_designer.js",
);

$controller = new DesignerController();
$controller->add($title,$header,$css_file_array,$js_file_array);

?>




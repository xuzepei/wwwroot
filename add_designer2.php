<!DOCTYPE html>
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

        <title>添加设计师</title>

        <!-- Bootstrap core CSS -->
        <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- My CSS -->
        <link href="./css/add_designer.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css"></style><style>[touch-action="none"]{ -ms-touch-action: none; touch-action: none; }[touch-action="pan-x"]{ -ms-touch-action: pan-x; touch-action: pan-x; }[touch-action="pan-y"]{ -ms-touch-action: pan-y; touch-action: pan-y; }[touch-action="scroll"],[touch-action="pan-x pan-y"],[touch-action="pan-y pan-x"]{ -ms-touch-action: pan-x pan-y; touch-action: pan-x pan-y; }</style></head>

    <body>

        <!-- My JS -->
        <script language="javascript" type="text/javascript" src="./js/add_designer.js"></script>

        <!-- Wrap all page content here -->
        <div id="wrap">

            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1>添加设计师</h1>
                </div>
            </div>


            <form id="info_form" method="post" enctype="multipart/form-data" action="add_designer.php?action=submit">
                <table id="designer_info_table" width="547" border="0">
                    <tr>
                        <th width="66" height="60">姓名：</th>
                        <td width="152">
                            <input type="text" name="name" id="name" size="30">
                        </td>
                        <td width="307"></td>
                    </tr>
                    <tr>
                        <th height="60">年龄：</th>
                        <td><input type="text" name="age" id="age" size="30" onkeyup="validate_age()">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th height="60">性别：</th>
                        <td>
                            <input type="radio" name="male_radio" value="0" id="male_radio">
                            男</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="female_radio" value="1" id="female_radio">
                                女</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th height="60">手机号：</th>
                        <td><input type="text" name="phone" id="phone" size="30" onkeyup="validate_phone()"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th height="60">头像：</th>
                        <td>
                            <input name="head_image" id="head_image" type="file" size="30" accept="image/jpeg,image/png" ></td>
                    </tr>
                    <tr>
                        <th height="100">介绍:</th>
                        <td>
                            <textarea name="desc" id="desc"></textarea></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th height="100"></th>
                        <td>
                            <input type="submit" id="add_designer_button" value="提交"></td>
                        <td></td>
                    </tr>
                </table>         
            </form>

            <?php
            
            $uploadImageFailed = false;
            $save_path;
            $head_image_url;
            
            if ($_FILES["head_image"]["error"] > 0) {
                $uploadImageFailed = true;
                //echo "Error: " . $_FILES["head_image"]["error"] . "<br/>";
            } else if (false == empty($_FILES["head_image"])) {
                echo "Upload: " . $_FILES["head_image"]["name"] . "<br />";
                echo "Type: " . $_FILES["head_image"]["type"] . "<br />";
                echo "Size: " . ($_FILES["head_image"]["size"] / 1024) . " Kb<br />";

                $save_path = "../upload/" . $_FILES["head_image"]["name"];
                if (file_exists($_FILES["head_image"]["tmp_name"]) && is_uploaded_file($_FILES["head_image"]["tmp_name"])) {
                    echo "temp path:" . $_FILES["head_image"]["tmp_name"] . "<br/>";
                    //sleep(60);
                    
                    if (false == move_uploaded_file($_FILES["head_image"]["tmp_name"], $save_path)) {
                        echo "Destination:" . $save_path . "<br />";
                        echo "Moving uploaded file failed!";
                        $uploadImageFailed = true;
                    }
                    else
                    {
                        echo "Stored in: " . $save_path;
                        $head_image_url = $_FILES["head_image"]["name"];
                    }
                }
                else {
                    
                    $uploadImageFailed = true;
                    echo "Can't find uploaded file!";
                }
            }
            
            $action = $_GET["action"];
            if (isset($action) && !strcmp($action, "submit")) {
                if (false == $uploadImageFailed && isset($save_path)) {
                    
                    $name = $_POST["name"];
                    if (isset($name) && strlen($name)) {
                    
                    $age = $_POST["age"];
                    if(!isset($age))
                        $age = '';
                    
                    $gender = $_POST["gender"];
                    if(!isset($gender))
                        $gender = -1;
                    
                    $phone = $_POST["phone"];
                    if(!isset($phone))
                        $phone = '';
                    
                    $desc = $_POST["desc"];
                    if(!isset($desc))
                        $desc = '';
                    
                    $type = $_POST["type"];
                    if(!isset($type))
                        $type = 0;
                    
                    if(!isset($head_image_url))
                        $head_image_url = '';

                    //上传成功，写入数据库
                    require_once 'db/medoo.php';
                    $database = new medoo([
                        // required
                        'database_type' => 'mysql',
                        'database_name' => 'gongzhang_db',
                        'server' => '127.0.0.1',
                        'username' => 'root',
                        'password' => '123',
                        // optional
                        'port' => 3306,
                        'charset' => 'utf8',
                    ]);
                    
                    $result = $database->insert("designer_tb", [
                        "name" => $name,
                        "age" => $$age,
                        "gender" => $gender,
                        "phone" => $phone,
                        "description" => $desc,
                        "head_image_url" => $head_image_url,
                    ]);
                    
                    if($result)
                    {
                        echo '<script type="text/javascript" >alert("成功添加设计师！");</script>';
                    }
                        
                    }
                    
                } else {
                    echo '<script type="text/javascript" >alert("上传头像失败！");</script>';
                }
            }
            
            ?>


            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->


    </body></html>


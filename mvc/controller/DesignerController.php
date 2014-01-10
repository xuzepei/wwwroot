<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './mvc/model/Designer.php';

class DesignerController {
    

    public $db_name = 'gongzhang_db';
    public $tb_name = 'designer_tb';
        
    public function __construct()
    {
    }

    public function invoke()
    {
        $action = $_GET['action'];
        $id = $_GET['id'];
        if(isset($id) && isset($action) && 0 == strcmp($action,"delete"))
        {
            $this->removeById($id);
        }

        $designers = $this->getItemList();
        include './mvc/view/designer_list.php';
    }

    public function getItemList()
    {
        require_once './db/medoo.php';
        $database = new medoo($this->db_name);
        $result = $database->select($this->tb_name, "*");
        
        $designer_array;
        $i = 0;
        foreach($result as $designer_info)
        {
            $designer_array[$i] = new Designer($designer_info);
            $i++;
        }
        return $designer_array;
    }

    public function getItem($id)
    {
        $array = $this->getItemList();
        return $array[$id];
    }
    
    public function removeById($id)
    {
        //require_once 'error_log_setting.php';
        require_once './db/medoo.php';
        $database = new medoo($this->db_name);
        $database->delete($this->tb_name, ["id"=>$id]);
    }

    public function add($title, $header, $css_file_array, $js_file_array)
    {
        include './mvc/view/header.php';
        
        $uploadImageFailed = false;
        $save_path;
        $head_image_url;

        if ($_FILES["head_image"]["error"] > 0)
        {
            $uploadImageFailed = true;
            //echo "Error: " . $_FILES["head_image"]["error"] . "<br/>";
        }
        else if (false == empty($_FILES["head_image"]))
        {
            //echo "Upload: " . $_FILES["head_image"]["name"] . "<br />";
            //echo "Type: " . $_FILES["head_image"]["type"] . "<br />";
            //echo "Size: " . ($_FILES["head_image"]["size"] / 1024) . " Kb<br />";

            $save_path = "../upload/" . $_FILES["head_image"]["name"];
            if (file_exists($_FILES["head_image"]["tmp_name"]) && is_uploaded_file($_FILES["head_image"]["tmp_name"]))
            {
                //echo "temp path:" . $_FILES["head_image"]["tmp_name"] . "<br/>";
                //sleep(60);

                if (false == move_uploaded_file($_FILES["head_image"]["tmp_name"], $save_path))
                {
                    //echo "Destination:" . $save_path . "<br />";
                    //echo "Moving uploaded file failed!";
                    $uploadImageFailed = true;
                }
                else
                {
                    //echo "Stored in: " . $save_path;
                    $head_image_url = $_FILES["head_image"]["name"];
                }
            }
            else
            {

                $uploadImageFailed = true;
                //echo "Can't find uploaded file!";
            }
        }

        $action = $_GET["action"];
        if (isset($action) && !strcmp($action, "submit"))
        {
            $error_text = '';
            
            if(false == $uploadImageFailed && isset($save_path))
            {
                $name = $_POST["name"];
                if (isset($name) && strlen($name))
                {
                    $age = $_POST["age"];
                    if (!isset($age))
                    {
                        $age = '';
                    }

                    $gender = $_POST["gender_group"];
                    if (!isset($gender))
                        $gender = -1;

                    $type = $_POST["type"];
                    if (!isset($type))
                        $type = 0;

                    $phone = $_POST["phone"];
                    if (!isset($phone))
                        $phone = '';

                    $desc = $_POST["desc"];
                    if (!isset($desc))
                        $desc = '';

                    if (!isset($head_image_url))
                        $head_image_url = '';

                    //上传成功，写入数据库
                    require_once 'db/medoo.php';
                    $database = new medoo('gongzhang_db');

                    $result = $database->insert("designer_tb", [
                        "name" => $name,
                        "age" => $age,
                        "gender" => $gender,
                        "phone" => $phone,
                        "description" => $desc,
                        "head_image_url" => $head_image_url,
                        "type" => $type,
                            ]);

                    if ($result)
                    {
                        echo '<div class="alert alert-success">'."已成功添加设计师！".'</div>';
                        
                        echo '<script type="text/javascript" >
                            window.location.href="'."/index.php".'"; 
                            </script>';
                    }
                }
                else
                    $error_text = "添加设计师失败。提示：姓名不能为空！";
            }
            else
            {
                //echo '<script type="text/javascript" >alert("上传头像失败！");</script>';
                $error_text = "添加设计师失败。提示：添加头像失败！";
            }
            
            if(strlen($error_text))
            {
                include 'mvc/view/add_designer_form.php';
                
                if(file_exists($save_path))
                {
                    unlink($save_path);
                }
                echo '<div class="alert alert-danger">'.$error_text.'</div>';
            }
        }
        else
            include 'mvc/view/add_designer_form.php';

        include 'mvc/view/footer.php';
    }

}
?>


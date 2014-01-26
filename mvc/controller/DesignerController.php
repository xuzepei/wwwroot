<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once BASE_PATH . '/mvc/model/Designer.php';

class DesignerController {

    public $db_name = DB_NAME;
    public $tb_name = 'designer_tb';

    public function __construct()
    {
        
    }

    public function invoke()
    {
        $title = TITLE;
        $head1 = '设计师';
        $css_file_array = array('/bootstrap/v3/css/bootstrap.css');

        include BASE_PATH . '/mvc/view/header.php';

        $page = $_GET['page'];
        $count = $_GET['count'];
        if (!isset($page) || $page <= 0)
            $page = 1;
        if (!isset($count) || $count < 0)
            $count = PAGE_SIZE;

        $action = $_GET['action'];
        $id = $_GET['id'];
        if (isset($id) && isset($action) && 0 == strcmp($action, "delete"))
        {
            $this->removeById($id);
        }

        $designers = $this->getItems($page, $count);
        include BASE_PATH . '/mvc/view/designer_list.php';
        $this->page_controller($page, $count);
        include BASE_PATH . '/mvc/view/footer.php';
    }

    public function getItems($page, $count)
    {
        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo($this->db_name);
        $from_index = ($page - 1) * $count;
        $result = $database->select_by_sql('select * from ' . $this->tb_name . ' limit ' . $from_index . ',' . $count);

        $designer_array;
        $i = 0;
        foreach ($result as $designer_info)
        {
            $designer_array[$i] = new Designer($designer_info);
            $i++;
        }
        return $designer_array;
    }

    public function getAllItems()
    {
        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo($this->db_name);
        $result = $database->select($this->tb_name, "*");

        $designer_array;
        $i = 0;
        foreach ($result as $designer_info)
        {
            $designer_array[$i] = new Designer($designer_info);
            $i++;
        }
        return $designer_array;
    }

    public function getItemsCount()
    {
        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo($this->db_name);
        $result = $database->count('select count(*) from ' . $this->tb_name);

        return $result;
    }

    public function getItem($id)
    {
        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo($this->db_name);
        $result = $database->select_by_sql('select * from ' . $this->tb_name . ' where id=' . $id . ' limit 1');

        $designer_array;
        $i = 0;
        foreach ($result as $designer_info)
        {
            $designer_array[$i] = new Designer($designer_info);
            $i++;
        }
        return $designer_array;
    }

    public function removeById($id)
    {
        //require_once 'error_log_setting.php';
        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo($this->db_name);
        $database->delete($this->tb_name, ["id" => $id]);
    }

    public function add($title, $header, $css_file_array, $js_file_array)
    {
        include BASE_PATH . '/mvc/view/header.php';

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

            if (false == $uploadImageFailed && isset($save_path))
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
                    require_once BASE_PATH . 'db/medoo.php';
                    $database = new medoo($this->db_name);

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
                        echo '<div class="alert alert-success">' . "已成功添加设计师！" . '</div>';

                        echo '<script type="text/javascript" >
                            window.location.href="' . "/index.php" . '"; 
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

            if (strlen($error_text))
            {
                include 'mvc/view/add_designer_form.php';

                if (file_exists($save_path))
                {
                    unlink($save_path);
                }
                echo '<div class="alert alert-danger">' . $error_text . '</div>';
            }
        }
        else
            include BASE_PATH . 'mvc/view/add_designer_form.php';

        include BASE_PATH . 'mvc/view/footer.php';
    }

    public function test()
    {
        echo 'test from ' . __FILE__;
    }

    private function page_controller($page, $count)
    {
//            <ul class="pagination">
//      <li><a href="#">&laquo;</a></li>
//      <li><a href="#">1</a></li>
//      <li><a href="#">2</a></li>
//      <li><a href="#">3</a></li>
//      <li><a href="#">4</a></li>
//      <li><a href="#">5</a></li>
//      <li><a href="#">&raquo;</a></li>
//    </ul>

        //页面数量
        $sum = $this->getItemsCount();
        $page_count = floor($sum / $count);
        if ($sum % $count != 0)
            $page_count += 1;
        
        if(1 == $page_count || $page > $page_count)
            return;

        $li_count = min($page_count, 5);//最多显示5个页面按钮

        //前一页索引
        $previous_page = max(0, $page - 1);
        //后一页索引
        $next_page = min($page_count, $page + 1);

        $previous_li = '';
        if ($page - 1 <= 0)
            $previous_li = '<li class="disabled"><a href="' . BASE_URL . '?c=designer&page=' . $previous_page . '">&laquo;</a></li>';
        else
            $previous_li = '<li><a href="' . BASE_URL . '?c=designer&page=' . $previous_page . '">&laquo;</a></li>';

        $base_index = floor(($page - 1)/ $li_count);
        $lis = '';
        for ($i = 1; $i < $li_count + 1; $i++)
        {
            $li = '';
            $index = $base_index * $li_count + $i;
            if($index > $page_count)
                continue;
            
            if ($index == $page)
                $li = '<li class="active"><a href="' . BASE_URL . '?c=designer&page=' . $index . '">' . $index . '</a></li>';
            else
                $li = '<li><a href="' . BASE_URL . '?c=designer&page=' . $index . '">' . $index . '</a></li>';
            $lis .= $li;
        }
        
        $next_li = '';
        if ($page >= $page_count)
            $next_li = '<li class="disabled"><a href="' . BASE_URL . '?c=designer&page=' . $next_page . '">&raquo;</a></li>';
        else
            $next_li = '<li><a href="' . BASE_URL . '?c=designer&page=' . $next_page . '">&raquo;</a></li>';

        echo '<ul class="pagination">' . $previous_li . $lis .$next_li.'</ul>';
    }

}
?>


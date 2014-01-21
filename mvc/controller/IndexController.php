<?php



class IndexController {
    

    public function __construct()
    {
    }

    public function invoke()
    {
        $this->welcome();
    }

    public function welcome()
    {
        $title = TITLE;
        $head1 = '欢迎';
        $css_file_array = array('/bootstrap/v3/css/bootstrap.css');

        include BASE_PATH.'/mvc/view/header.php';
        include BASE_PATH.'/mvc/view/footer.php';
    }
    
    public function test()
    {
        echo '<a class="navbar-brand" href='.BASE_URL.'>'.$title.'</a>';
    }


}
?>


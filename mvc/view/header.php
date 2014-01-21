
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

        <title><?php echo $title?></title>

        <!-- CSS -->
        <?php
            foreach($css_file_array as $css_file)
            {
                echo '<link href="'.BASE_URL.$css_file.'" rel="stylesheet">';
            }
        ?>
        
        <!-- JS -->
        <?php
            if(isset($js_file_array))
            {
                foreach($js_file_array as $js_file)
                {
                    echo '<script language="javascript" type="text/javascript" src="'.BASE_URL.$js_file.'"></script>';
                }
            }
        ?>

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css"></style><style>[touch-action="none"]{ -ms-touch-action: none; touch-action: none; }[touch-action="pan-x"]{ -ms-touch-action: pan-x; touch-action: pan-x; }[touch-action="pan-y"]{ -ms-touch-action: pan-y; touch-action: pan-y; }[touch-action="scroll"],[touch-action="pan-x pan-y"],[touch-action="pan-y pan-x"]{ -ms-touch-action: pan-x pan-y; touch-action: pan-x pan-y; }</style></head>

    <body>
        <!-- navigation bar-->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    <?php echo '<a class="navbar-brand" href='.BASE_URL.'>'.$title.'</a>'; ?>
                </div>
                <div class="navbar-collapse collapse">


                    
                                        <?php

 echo '<ul class="nav navbar-nav">'.'<li><a href='.$BASE_URL.'?c=designer'.'>设计师</a></li><li><a href="#about">关于我们</a></li><li><a href="#contact">联系我们</a></li></ul><p class="navbar-text pull-right">';

if(isset($_SESSION['username']))
{
    echo '<a href='.'"'.$BASE_URL.'?c=user&m=info'.'"'.'class="navbar-link">'.$_SESSION['username'].'</a>   |   '.'<a href='.'"'.$BASE_URL.'?c=user&m=logout'.'"'.'class="navbar-link">退出</a>';
}
else
{
    echo '<a href='.'"'.$BASE_URL.'?c=user&m=login'.'"'.'class="navbar-link">登录</a>   |   '.'<a href='.'"'.$BASE_URL.'?c=user&m=register'.'"'.'class="navbar-link">注册</a>';
}
                    ?>
            </p>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        
        <!-- Wrap all page content here -->
        <div id="wrap">
            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1><?php echo $head1;?></h1>
                </div>
                <p>

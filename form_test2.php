<html>
	<head>
		<title></title>
	</head>
	<body>
		
		<?php
                        $post_name = isset($_POST["name"])?$_POST["name"]:null;
                        $post_age = isset($_POST["age"])?$_POST["age"]:null;
                        $get_name = isset($_GET["name"])?$_GET["name"]:null;
                        
		 	if(strlen($post_name) && strlen($post_age))//post方法
			{
				echo "Welcome ".$post_name.".<br/>"."You are ".$post_age." years old.";
			}
			else if(strlen($get_name))//get方法
			{
				echo "Welcome ".$get_name.".<br/>";
			}
			else
			{
				echo '<form action="form_test2.php" method="post">
					Name:<input type="text" name="name"/> 
					Age:<input type="text" name="age"/> 
					<input type="submit"/>
				</form>';
			}
		
		?>
	</body>
</html>

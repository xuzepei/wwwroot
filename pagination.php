<?php
$perpagenum = 10; //定义每页显示几条    
$total = mysql_fetch_array(mysql_query("select count(*) from a")); //查询数据库中一共有多少条数据    
$Total = $total[0];                          //    
$Totalpage = ceil($Total / $perpagenum); //上舍，取整    
if (!isset($_GET['page']) || !intval($_GET['page']) || $_GET['page'] > $Totalpage) {//page可能的四种状态    
    $page = 1;
} else {
    $page = $_GET['page']; //如果不满足以上四种情况，则page的值为$_GET['page']    
}
$startnum = ($page - 1) * $perpagenum; //开始条数    
$sql = "select * from a order by id limit $startnum,$perpagenum"; //查询出所需要的条数    
echo $sql . "    
";
$rs = mysql_query($sql);
$contents = mysql_fetch_array($rs);


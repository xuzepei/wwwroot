<?php

require_once '../tool/Curl.class.php';

date_default_timezone_set("PRC");

$url = 'http://ozone.10jqka.com.cn/tg_templates/doubleone/2015/guminSchool/?first=first';

$homepage = file_get_contents($url);
echo $homepage;

//getAndParse($url);

function getAndParse($url) {

    if (0 == strlen($url))
        return;

    $ch = curl_init();
    $timeout = 20;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $html = curl_exec($ch);
    curl_close($ch);

    if ($html != FALSE) {
        $dom = new DOMDocument();
        @$b = $dom->loadHTML($html);
        if ($b != FALSE) {
            //find by class name
            $finder = new DomXPath($dom);
            $classname="index_top";
            $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

            foreach ($nodes as $node)
            {
                $node->parentNode->removeChild($node);
            }
        }
    }
    
    echo $html;
}

function getDateFromString($date_string) {
    $date = '';

    if (strlen($date_string) > 0) {
        $date_string = trim($date_string);
        $date_string = substr($date_string, -11);

        if (11 == strlen($date_string)) {
            $day = substr($date_string, 0, 2);
            $month = substr($date_string, 3, 3);
            $year = substr($date_string, 7, 4);

//            $day = @intval($day);
//            $month = @intval($month);
//            $year = @intval($year);
//            echo $date_string.':'.$year.'|'.$month.'|'.$day.'<br>';
            //$date = mktime(0,0,0,$month,$day,$year);s
            //echo $day.' '.$month.' '.$year.'<br>';
            $date = strtotime($day . ' ' . $month . ' ' . $year);
        }
    }

    return $date;
}

function saveToDB($array) {
    if (count($array) != 0) {

        $mysql = new SaeMysql();

        foreach ($array as $item) {
            $sql = "INSERT INTO bbc_tb (title, cate_id, url, img_url, description, mp3_url, pdf_url, date) VALUES (";
            $sql = $sql . '\'' . $item['title'] . '\', ' . '\'' . $item['cate_id'] . '\', ' . '\'' . $item['url'] . '\', ' . '\'' . $item['img_url'] . '\', ' . '\'' . $item['desc'] . '\', ' . '\'' . $item['mp3_url'] . '\', ' . '\'' . $item['pdf_url'] . '\', ' . '\'' . $item['date'] . '\'';
            $sql = $sql . ')';
            //echo $sql;

            $mysql->runSql($sql);
            if ($mysql->errno() != 0) {
                //die("Error:" . $mysql->errmsg());
            }
        }

        echo 'cate_id: ' . $item['cate_id'] . '-------OK.';
        $mysql->closeDb();
    }
}


function goToWebpage($url)
{ 
    return '<script language="javascript"
    type="text/javascript">window.location.href="'.$url.'";</script>';
}


<?php

require_once '../tool/Curl.class.php';

date_default_timezone_set("PRC");

$url = '';
$type = $_GET["type"];
if (!isset($type))
    $type = 0;

if (0 == $type) //World
    $url = 'http://learningenglish.voanews.com/api/zymppeq$pp';
else if (1 == $type)// Words in the news
    $url = 'http://www.bbc.co.uk/learningenglish/english/features/witn/ep-150513';
else if (2 == $type)// 6 minute English
    $url = 'http://www.bbc.co.uk/learningenglish/english/features/6-minute-english/ep-150514';
else if (3 == $type)// Drama
    $url = 'http://www.bbc.co.uk/learningenglish/english/features/drama/jamaica-ep02';
else if (4 == $type)// New Report
    $url = 'http://www.bbc.co.uk/learningenglish/english/features/news-report/ep-150518';

getAndParse($url, $type);

function getAndParse($url, $cate_id) {

    if (0 == strlen($url))
        return;

    $ch = curl_init();
    $timeout = 20;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $xml = curl_exec($ch);
    curl_close($ch);

    if ($xml != FALSE) {
        $dom = new DOMDocument();
        @$b = $dom->loadXML($xml);
        if ($b != FALSE) {

            $item_array = array();

            //Get 'item' tag list
            $item_tag_list = $dom->getElementsByTagName('item');
            foreach ($item_tag_list as $item_tag) {

                $title = '';
                $description = '';
                $link = '';
                $pubDate = '';
                $imageUrl = '';

                $obj = $item_tag->getElementsByTagName('title');
                if ($obj) {

                    if (0 == strcmp($obj->item(0)->nodeName, 'title'))
                        $title = $obj->item(0)->nodeValue;
                }

                $obj = $item_tag->getElementsByTagName('description');
                if ($obj) {
                    if (0 == strcmp($obj->item(0)->nodeName, 'description'))
                        $description = $obj->item(0)->nodeValue;
                }

                $obj = $item_tag->getElementsByTagName('link');
                if ($obj) {
                    if (0 == strcmp($obj->item(0)->nodeName, 'link'))
                        $link = $obj->item(0)->nodeValue;
                }

                $obj = $item_tag->getElementsByTagName('pubDate');
                if ($obj) {
                    if (0 == strcmp($obj->item(0)->nodeName, 'pubDate'))
                        $pubDate = $obj->item(0)->nodeValue;
                    
                    $pubDate = strtotime($pubDate);
                    if($pubDate == FALSE)
                        $pubDate = '';
                }

                $obj = $item_tag->getElementsByTagName('enclosure');
                if ($obj) {
                    if (0 == strcmp($obj->item(0)->attributes->item(0)->nodeName, 'url'))
                        $imageUrl = $obj->item(0)->attributes->item(0)->nodeValue;
                }

                $item = array(
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'pubDate' => $pubDate,
                    'imageUrl' => $imageUrl,
                );

                array_push($item_array, $item);
            }

            echo json_encode($item_array);
        }
    }
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

function goToWebpage($url) {
    return '<script language="javascript"
    type="text/javascript">window.location.href="' . $url . '";</script>';
}

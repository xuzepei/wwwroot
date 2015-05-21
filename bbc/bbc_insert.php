<?php

require_once '../tool/Curl.class.php';

date_default_timezone_set("PRC");

$url = '';
$type = $_GET["type"];
if (!isset($type))
    $type = 0;

if (0 == $type) // The English we speak
    $url = 'http://www.bbc.co.uk/learningenglish/english/features/the-english-we-speak/ep-150519';
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
    $html = curl_exec($ch);
    curl_close($ch);

    if ($html != FALSE) {
        $dom = new DOMDocument();
        @$b = $dom->loadHTML($html);
        if ($b != FALSE) {
            //find by class name
            //$finder = new DomXPath($dom);
            //$classname="item first";
            //$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

            $li_tag_array = array();

            //Get 'ul' tag list
            $ul_tag = null;
            $tag_list = $dom->getElementsByTagName('ul');
            foreach ($tag_list as $tag) {
                $value = $tag->getAttribute('data-max-results');
                if ($value && strlen($value) != 0) {
                    $ul_tag = $tag;
                    break;
                }
            }

            if ($ul_tag == null)
                return;

            //Get 'li' tag list
            $tag_list = $ul_tag->childNodes;

            foreach ($tag_list as $tag) {
                $class_name = $tag->getAttribute('class');
                if (0 == strcmp($class_name, 'item first') || 0 == strcmp($class_name, 'item')) {
                    array_push($li_tag_array, $tag);
                }
            }

            $result_array = array();
            //parse 'li' tag
            foreach ($li_tag_array as $li) {
                $url = '';
                $img_url = '';
                $desc = '';
                $title = '';
                $mp3_url = '';
                $pdf_url = '';
                $date = '';

                //url
                $tag_list = $li->getElementsByTagName('a');
                if ($tag_list->length > 0) {
                    $temp = $tag_list->item(0);
                    $url = 'http://www.bbc.co.uk' . $temp->getAttribute('href');
                }

                //date
                $tag_list = $li->getElementsByTagName('h4');
                if ($tag_list->length > 0) {
                    $temp = $tag_list->item(0);
                    $date = getDateFromString($temp->nodeValue);
                }

                //image url
                $tag_list = $li->getElementsByTagName('img');
                if ($tag_list->length > 0) {
                    $temp = $tag_list->item(0);
                    $img_url = $temp->getAttribute('src');
                    if (strlen($img_url) > 4) {
                        $img_url = substr_replace($img_url, '/624', -4);
                    }

                    //title
                    $title = $temp->getAttribute('alt');
                }

                //description
                $tag_list = $li->getElementsByTagName('p');
                foreach ($tag_list as $tag) {
                    $class_name = $tag->getAttribute('class');
                    if (0 == strcmp($class_name, 'text')) {
                        $desc = $tag->nodeValue;
                        break;
                    }
                }

                //mp3 and pdf urls
                $tag_list = $dom->getElementsByTagName('a');
                foreach ($tag_list as $tag) {
                    $class_name = $tag->getAttribute('class');
                    if (0 == strcmp($class_name, 'download')) {

                        $temp_url = $tag->getAttribute('href');
                        if (strlen($temp_url) > 0) {
                            $temp = substr($temp_url, -4);
                            if (0 == strcasecmp($temp, '.mp3') && 0 == strlen($mp3_url))
                                $mp3_url = $temp_url;
                            else if (0 == strcasecmp($temp, '.pdf') && 0 == strlen($pdf_url))
                                $pdf_url = $temp_url;
                        }
                    }
                }

                $result = array(
                    'title' => mysql_escape_string($title),
                    'cate_id' => mysql_escape_string($cate_id),
                    'url' => mysql_escape_string($url),
                    'img_url' => mysql_escape_string($img_url),
                    'desc' => mysql_escape_string($desc),
                    'mp3_url' => mysql_escape_string($mp3_url),
                    'pdf_url' => mysql_escape_string($pdf_url),
                    'date' => mysql_escape_string($date),
                );

                array_push($result_array, $result);
            }

            echo json_encode($result_array);
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

<?php
    $url = "http://guxfs.com"; 
    $contents = file_get_contents($url);
    $getcontent = iconv("gb2312", "utf-8",$contents); 
    echo $contents;
 ?>
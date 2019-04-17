<?php

    // 返回轮播图数据 
    $sql ="select value from options where id = 10";

    include_once '../../fn.php';
    $res = my_select($sql);

    echo $res[0]['value'];

    // $arr = json_decode($res[0]['value'], true);

    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';

?>
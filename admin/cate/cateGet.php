<?php

    //获取所有分类信息
    $sql = "select * from categories";

    include_once '../../fn.PHP';
    $arr = my_select($sql);

    echo json_encode($arr);





?>
<?php

    // 1. 获取id
    $id = $_GET['id'];
    // 2. 拼接sql语句
    $sql = "select * from posts where id = $id";
    // 3. 引入文件,执行方法
    include_once '../../fn.php';
    $arr = my_select($sql);
    // 4. 返回数据
    echo json_encode($arr);




?>
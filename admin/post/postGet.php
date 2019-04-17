<?php

    // 1. 准备sql语句
    $page = $_GET['page'];
    // 第一页： 0，10
    // 第二页： 10，10
    // 第三页： 20，10
    $index = ($page - 1) * 10;
    // 需要联合用户表和分类表
    $sql = "select posts.*, users.nickname, categories.name from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id order by posts.id desc limit $index, 10";
    // 2. 引入文件，执行方法
    include_once '../../fn.php';
    $arr = my_select($sql);
    // 3. 返回数据
    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';
    echo json_encode($arr);



?>
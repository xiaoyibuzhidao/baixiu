<?php

    $cateid = $_GET['cateid'];
    $page = $_GET['page'];

    
    $index = ($page - 1) * 10;

    if($cateid == 0){
        $sql = "select posts.*, users.nickname, categories.name from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id order by posts.id desc limit $index, 10";
    }else{
        $sql = "select posts.*, users.nickname, categories.name from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id where posts.category_id = $cateid order by posts.id desc limit $index, 10";
    }
    // 2. 引入文件，执行方法
    include_once '../../fn.php';
    $arr = my_select($sql);
    // 3. 返回数据
    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';
    echo json_encode($arr);


?>
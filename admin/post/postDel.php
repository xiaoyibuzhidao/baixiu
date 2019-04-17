<?php

    // 1. 获取id
    $id = $_GET['id'];
    // 2. 拼接sql语句
    $sql = "delete from posts where id = $id";
    // 3. 引入文件,执行方法
    include_once '../../fn.php';
    my_exec($sql);

    $cateid = $_GET['cateid'];

    if($cateid == 0){
        $sql = "select count(*) as total from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id";
    }else{
        $sql = "select count(*) as total from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id where posts.category_id = $cateid";
    }
    
    $arr = my_select($sql)[0];

    echo json_encode($arr);
    



?>
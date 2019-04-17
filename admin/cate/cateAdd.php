<?php

    // 1. 获取数据
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    // 2. 拼接sql语句
    $sql = "insert into categories (name, slug) values ('$name', '$slug')";
    // 3. 引入文件,执行方法
    include_once '../../fn.php';
    my_exec($sql);





?>
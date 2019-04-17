<?php

    //返回所有的用户信息

    $sql = "select * from users";

    include_once '../../fn.php';
    $arr = my_select($sql);

    echo json_encode($arr);






?>
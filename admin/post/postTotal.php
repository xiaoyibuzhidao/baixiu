<?php

    $sql = "select count(*) as total from posts join users on posts.user_id = users.id join categories on posts.category_id = categories.id";

    include_once '../../fn.php';
    $arr = my_select($sql)[0];

    echo json_encode($arr);


?>
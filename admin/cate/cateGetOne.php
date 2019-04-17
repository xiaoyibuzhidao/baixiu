<?php
    $id = $_GET['id'];
    $sql = "select * from categories where id = $id";
    include_once '../../fn.php';
    $arr = my_select($sql)[0];

    echo json_encode($arr);


?>
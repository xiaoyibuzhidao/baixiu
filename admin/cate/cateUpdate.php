<?php

    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $id = $_POST['id'];

    $sql = "update categories set name = '$name', slug = '$slug' where id = $id";

    include_once '../../fn.php';
    my_exec($sql);




?>
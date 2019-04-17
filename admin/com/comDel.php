<?php


//  1. 获取id
$id = $_GET['id'];
//  2. 拼接sql语句
$sql = "delete from comments where id in ($id)";
//  3. 引入文件,执行方法
include_once '../../fn.php';
my_exec($sql);

// 获取新的数据总数
$sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";
// 2. 引入文件,执行方法
$res = my_select($sql)[0];

// echo '<pre>';
// print_r($res);
// echo '</pre>';
// 3. 返回数据
echo json_encode($res);


?>
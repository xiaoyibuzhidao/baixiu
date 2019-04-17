<?php

// 需求: 给前端返回评论的数据
// 1. 拼接sql语句
// select * from 表A join 表B on 表A.post_id = 表B.id

// 做分页功能
// 1. 需要前端上传一个页数 从1开始
$page = $_GET['page'];
$index = ($page - 1) * 10;
// 2. 具体裁剪数据的行为是后台来做,返回裁剪好的数据
//  第一页 :      limit 0, 10
//  第二页 :     limit 10, 10
//  第三页 :     limit 20, 10
$sql = "select comments.*, posts.title from comments join posts on comments.post_id = posts.id limit $index, 10";
// 2. 引入文件,执行方法
include_once '../../fn.php';
$arr = my_select($sql);
// 3. 返回数据
echo json_encode($arr);

?>
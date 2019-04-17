<?php
  // 返回评论的数据总数(注意: 如果文章删除,有效评论会减少)
  // 所以评论表和文章表要联合查询
  // 1. 准备sql语句
  $sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";
  // 2. 引入文件,执行方法
  include_once '../../fn.php';
  $res = my_select($sql)[0];

  // echo '<pre>';
  // print_r($res);
  // echo '</pre>';
  // 3. 返回数据
  echo json_encode($res);




?>
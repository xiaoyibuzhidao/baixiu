<?php

  //需求: 将待审核的数据的状态改为批转
  // 1. 接收上传上来的id
  $id =  $_GET['id'];
  // 2. 拼接sql语句
  $sql = "update comments set status = 'approved' where id in ($id) and status = 'held'";
  // 3. 引入文件,执行方法
  include_once '../../fn.php';
  my_exec($sql);
 

?>
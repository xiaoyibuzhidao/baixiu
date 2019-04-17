<?php
  include_once '../fn.php';
  isLogin();

  $page = 'index1';

  $sqlPosts = "select count(*) as total from posts";
  $sqlPostsDrafted = "select count(*) as total from posts where status = 'drafted'";
  $sqlCate = "select count(*) as total from categories";
  $sqlCom = "select count(*) as total from comments";
  $sqlComHeld = "select count(*) as total from comments where status = 'held'";


  $postsTotal = my_select($sqlPosts)[0]['total'];
  $postsDraftedTotal = my_select($sqlPostsDrafted)[0]['total'];
  $CateTotal = my_select($sqlCate)[0]['total'];
  $ComTotal = my_select($sqlCom)[0]['total'];
  $ComHeldTotal = my_select($sqlComHeld)[0]['total'];

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include 'inc/nav.php'?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $postsTotal?></strong>篇文章（<strong><?php echo $postsDraftedTotal?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $CateTotal?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $ComTotal?></strong>条评论（<strong><?php echo $ComHeldTotal?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php include 'inc/aside.php'?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>

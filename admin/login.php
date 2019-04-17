<?php

  include_once  '../fn.php';
  //login.php做两件事情:
  //  1. 如果get请求,就直接渲染页面
  // 2. 如果是post请求,就要接收表单上传的数据,验证用户名和密码,如果不对,则提示,如果正确就跳转到首页
  //2.1 判断是否是post请求
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //2.2 判断用户输入的内容是否为空
    if(empty($_POST['email']) || empty($_POST['psw']) ){

      //  return; // 提示用户
      $msg = '请输入用户名或者密码';
    }else{
      // 验证用户名和密码
      //  2.3  先验证数据库表里面有没有用户名
      // 2.3.1 获取用户名
      $email = $_POST['email'];
      // 2.3.2 拼接查询用户名sql语句
      $sql = "select * from users where email = '$email'";
      // 2.3.3 执行方法
      $res = my_select($sql);
      // 2.3.4 判断
      if(empty($res)){
        //证明没有查询到
        $msg = '用户名错误';
      }else{
         // 如果有,则继续验证密码,如果没有,就提示用户.
        // 2.4 验证密码是否正确
        // $_POST['psw'] 和我们刚刚查到的数据进行对比 $res[0]['password']
         // 如果密码正确,就跳转到首页,如果密码不正确,就提示用户
        if($_POST['psw'] == $res[0]['password']){

            // 开启session
            session_start();
            // 往session里面存储一下当前的用户信息
            $_SESSION['userid'] = $res[0]['id'];
            //跳转到首页
            header('location: index1.php');
        }else{
          $msg = '密码错误';
        }
       

      }
    }
  }

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <!-- 判断$msg是否存在 -->
      <?php if(isset($msg)){?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $msg?>
        </div>
      <?php }?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="text" class="form-control" placeholder="邮箱" autofocus name="email">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码" name="psw">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>

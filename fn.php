<?php

  // 封装两个函数

 
  // 执行非查询的sql语句的函数
  function my_exec($sql){
    // 1. 连接数据库
    $link = mysqli_connect('127.0.0.1', 'root', 'root', 'baixiu');
    // 2. 判断是否连接成功, 判断不成功的情况下
    if(!$link){
      return;
    }
    // 3. 执行sql语句
    $res = mysqli_query($link, $sql);

    //判断执行的结果, 如果执行成功就返回true, 如果执行失败就返回false

    if($res){
      //证明成功了
      mysqli_close($link);
      return true;
    }else{
      //证明失败了
      //如果执行失败,基本上都是sql语句写错了.为了调试方便,最好输出一下sql语句执行时报的错误
      echo mysqli_error($link);
      mysqli_close($link);
      return false;
    }
  }



  // 执行查询的sql语句的函数
  function my_select($sql){
    // 1. 连接数据库
    $link = mysqli_connect('127.0.0.1', 'root', 'root', 'baixiu');
    // 2. 判断是否连接成功, 判断不成功的情况下
    if(!$link){
      return;
    }
    // 3. 执行sql语句
    $res = mysqli_query($link, $sql);

    //判断执行的结果, 如果执行成功就返回结果集, 如果执行失败就返回false
    if($res){
      //证明成功了
      // return 一个数组
      $arr = []; 

      for($i = 0; $i < mysqli_num_rows($res); $i++){
         $arr[] =   mysqli_fetch_assoc($res);
      }
      mysqli_close($link);
      return $arr;

    }else{
      //证明失败了
      //如果执行失败,基本上都是sql语句写错了.为了调试方便,最好输出一下sql语句执行时报的错误
      echo mysqli_error($link);
      mysqli_close($link);
      return false;
    }
  }




   //登录拦截要做的事情: 
  //  请求评论/分类等页面的时候,要先判断,当前是否是登录状态,如果是登录状态,则可以正常打开这个页面,如果不是登录的状态,要跳转到login.php
  function isLogin(){
    // 1. 先判断是否上传了phpsessid
    if(!empty($_COOKIE['PHPSESSID'])){
      // 2. 再判断,对应的session空间中是否有对应的用户id
      session_start();
      if(empty($_SESSION['userid'])){
        //跳转到login页面
        header('location: login.php');
      }
    }else{
      header('location: login.php');
    }
  }


?>
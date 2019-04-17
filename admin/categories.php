<?php
  //要判断,当前是否是登录的状态
  //如果登录则展示下面的html结构,如果不是登录状态,则跳转到login.php

  //如何判断,当前是不是登录状态
  // 1. 在登录验证成功的情况下,往sessoin里面存储一下当前登录用户的id
  // 2. 当我们访问对应的每一个页面(比如,评论,分类等),先判断session里面有没有这个id.如果有则证明当前是登录状态,如果没有则认为不是登录登录

  //增加一些健壮性的代码
  // 1. 先判断,浏览器是否给服务器上传了PHPSESSID.
  // 如果没有上传,直接跳转到login.php 
  // 2. 如果上传了, 在判断对应的空间中是否能查找到用户的id
  include_once '../fn.php';
  isLogin();

  $page = 'categories';



?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 需要引入nav.php -->
    <?php include 'inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" id="tip" style="display:none">
        <strong>错误！</strong><span id="mess"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新分类目录</h2>
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">              
              <input type="button" class="btn btn-primary" value="添加" id="btn-add">
              <input type="button" class="btn btn-primary" value="修改" id="btn-updateSave" style="display: none">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- 需要引入aside.php -->
  <?php include 'inc/aside.php'?>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script>NProgress.done()</script>

  <!-- 分类列表的模板 -->
  <script type="text/template" id="catelist">
        {{each list v}}
           <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>{{v.name}}</td>
                <td>{{v.slug}}</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs btn-update" data-id="{{v.id}}">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
        {{/each}}
  
  
  </script>

  <script>

   var result; //用来存储所有的分类数据

   render();
   function render(){
    $.ajax({
      url: 'cate/cateGet.php',
      dataType: 'json',
      success: function(res){
        result = res;
        // console.log(res);
        var obj = {
          list: res
        }

        var htmlstr = template('catelist', obj);
        $('tbody').html(htmlstr);
      }
    })
   }


    //添加分类

    $('#btn-add').on('click', function(){

      // 判断用户填写的别名是否和数据中重复,如果重复,就提示用户,并且不发送ajax请求
      var flag = false; // 用于判断是否别名重复. 默认是false. false就是不重复
      // 1. 获取别名
      var slug = $('#slug').val().trim();
      // 2. 遍历result,查看是否有重复
      result.forEach(function(item){
         if(slug == item.slug){
           //证明有重复,提示用户.并且不发送ajax请求
           flag = true;
         }
      })

      // console.log(data);

      // 判断遍历之后的结果,去决定ajax是否发送
      if(flag){
        // alert('重复了');
        $('#tip').show()
        $('#mess').text('别名重复')
        return;
      }


      $.ajax({
        url: 'cate/cateAdd.php',
        type: 'post',
        data: $('form').serialize(),
        beforeSend: function(){
          // 这个回调函数是在请求之前调用
          if($('#name').val().trim().length == 0 || $('#slug').val().trim().length == 0){
            //再beforeSend中执行了return false,请求不发送
            // alert('没有填写内容')
            $('#tip').show()
            $('#mess').text('分类名称或别名不能为空')
            return false;
          }
        },
        success: function(){
          render();

          //在js中, form的标签的dom对象身上有一个reset方法.这个方法就可以充值表单
          $('form')[0].reset();
          $('#tip').hide()
        }
      })
    })


    // 编辑按钮
    $('tbody').on('click', '.btn-update', function(){
        var id = this.dataset.id;

        $.ajax({
          url: 'cate/cateGetOne.php',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(res){
            // console.log(res);
            $('#name').val(res.name);
            $('#slug').val(res.slug);
            //给隐藏域添加value的值
            $('#id').val(res.id);
            //添加隐藏 ,修改显示
            $('#btn-add').hide();
            $('#btn-updateSave').show();
          }
        })
    })


    // 修改按钮
    $('#btn-updateSave').on('click', function(){

        $.ajax({
          url: 'cate/cateUpdate.php',
          type: 'post',
          data: $('form').serialize(),
          success: function(){
            //渲染列表
            render();
            //重置表单
            $('form')[0].reset();
            //添加展示,修改隐藏
            $('#btn-add').show();
            $('#btn-updateSave').hide();
          }
        })

    });
  
  
  
  </script>
</body>
</html>

<?php
  include_once '../fn.php';
  isLogin();

  $page = 'post-add';

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <!-- 1. 引入文件, css, js -->
  <link rel="stylesheet" href="../assets/vendors/wangEditor/wangEditor.min.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include 'inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="form">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" style="display:none"></textarea>
            <!-- 准备富文本编辑器的父盒子 -->
            <div id="box"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="strong">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none" id="img">
            <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <!-- <option value="1">未分类</option>
              <option value="2">潮生活</option> -->
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" >
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <!-- <option value="drafted">草稿</option>
              <option value="published">已发布</option> -->
            </select>
          </div>
          <div class="form-group">
              <button class="btn btn-primary"  id="btn">保存</button>
          </div>
        </div>
      </form>
     
    </div>
  </div>

  <?php include 'inc/aside.php'?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.min.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script>NProgress.done()</script>

  <!-- 分类的模板 -->
  <script type="text/template" id="catelist">
    {{each list v}}
      <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>

  <!-- 文章状态的模板 -->
  <!-- 如果便利数组: v 值, i 下标 -->
  <!-- 如果便利对象: v 值, i 键-->
  <script type="text/template" id="statuslist">
    {{each list v k}}
      <option value="{{k}}">{{v}}</option>
    {{/each}}
  </script>
   
<!-- 逻辑代码 -->
  <script>
    //1. 渲染富文本编辑器
    //调用富文本编辑器方法,渲染出来
    // 并且要让富文本编辑器和文本域关联起来
    var E = window.wangEditor;
    var editor =  new E('#box');
    editor.customConfig.onchange = function(html){
      $('textarea').html(html);
    }
    editor.create();

    //2. 增加别名同步功能
    // input 事件 输入的时候会触发
    $('#slug').on('input', function(){
      // console.log(this.value)
      // $('#strong').text(this.value);

      // if(this.value.trim() === ''){
      //   $('#strong').text('slug');
      // }else{
      //   $('#strong').text(this.value);
      // }

      $('#strong').text(this.value || 'slug');

    })

    //3. 预览图片
    // 3.1 只能传图片 accept="image/*"
    // 3.2 预览这个图片 
    $('#feature').on('change', function(){
      // alert(1);
      //判断是否上传文件
      if(this.files.length == 0){
        return;
      }
      
      var url = URL.createObjectURL(this.files[0]);
      console.log(url);
      
      $('#img').show().attr('src', url);
    })

    //渲染分类下拉列表
    $.ajax({
      url: 'cate/cateGet.php',
      dataType: 'json',
      success:function(res){
        console.log(res);

        var obj = {
          list: res
        }

        var htmlstr = template('catelist', obj);
        $('#category').html(htmlstr);

        
      }
    })
    

    //文章状态
    var state = {
       drafted: '草稿',
       published: '已发布',
       trashed: '回收站'
    }
    var htmlstr = template('statuslist', {list: state});
    $('#status').html(htmlstr);


    // 自定义时间
    //利用moment.js生成指定格式的日期字符串
    // 1. 引入文件
    // 2. moment().format('指定格式')
    var datestr = moment().format('YYYY-MM-DDTHH:mm');
    $('#created').val(datestr);

    // $('#btn').on('click', function(e){

    //   // console.log(1);

    //   // console.log($('#created').val());
    //   //时间格式
    //   // 2019-04-07T15:00 
    //     // YYYY-MM-DDTHH:mm

    //   $('#created').val('2018-01-01T00:00');
       
    //   return false;
    //   // e.preventDefault()
    // })


    // 点击保存,上传数据给后台,添加数据
    $('#btn').on('click', function(){

      //1. 实例化formdata
      var formdata = new FormData($('#form')[0]);
      $.ajax({
        url: 'post/postAdd.php',
        type: 'post',
        data: formdata,
        processData: false, //告诉jquery不需要解析formdata
        contentType: false, //告诉jquery不需要设置请求头
        success: function(){
           //跳转到posts.php页面
           location.href = 'posts.php'; 
        }
      })
      return false;
    })
  
  </script>
</body>
</html>

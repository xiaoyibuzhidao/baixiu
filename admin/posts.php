<?php
  include_once '../fn.php';
  isLogin();

  $page = 'posts';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
  <link rel="stylesheet" href="../assets/vendors/wangEditor/wangEditor.min.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/nav.php'?>
   
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
        <!-- 分类 -->
      <select name="category_id" id="filter">
        <!-- <option value="0">所有分类</option>
        <option value="1">未分类</option>
        <option value="2">奇趣事</option>
        <option value="3">会生活</option>
        <option value="4">去旅行</option> -->
      </select>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <!-- <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul> -->
        <div id="paginationBox" class="pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php include 'inc/aside.php'?>

  <!--引入编辑窗口  -->
  <?php include 'inc/edit.php'?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.min.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>

  <script>NProgress.done()</script>

  <!-- 文章列表 -->
  <script type="text/template" id="postlist">
    {{each list v}}
      <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.title}}</td>
            <td>{{v.nickname}}</td>
            <td>{{v.name}}</td>
            <td class="text-center">{{v.created}}</td>
            <td class="text-center">{{status[v.status]}}</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs btn-update" data-id="{{v.id}}">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del" data-id="{{v.id}}">删除</a>
            </td>
        </tr>
  
    {{/each}}
  </script>

  <!-- 分类列表 -->
  <script type="text/template" id="catelist">
    {{each list v}}
      <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>
  <!-- 状态模板 -->
  <script type="text/template" id="statuslist">
    {{each list v k}}
      <option value="{{k}}">{{v}}</option>
    {{/each}}
  </script>

  <!-- 下拉分类 -->
  <script type="text/template" id="catefilterlist">
    <option value="0">所有分类</option>
    {{each list v}}
      <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>


  
  <script>
    //注意:一般公司开发时,要求,全局变量写在最上面
    var currentPage = 1; //记录当前展示的页数
    var cateid = 0;
    // 草稿（drafted）/ 已发布（published）/ 回收站（trashed）
    // 注意: 在全局声明变量，就相当于是给window对象添加属性。
    // window对像本身就有status，name， top这个属性。 status默认是一个空的字符串，
    // 赋值为其他类型，也会转成字符串
     var state = {
       drafted: '草稿',
       published: '已发布',
       trashed: '回收站'
     }
     //删除
     $('tbody').on('click', '.btn-del', function(){
      
      //  获取id
      var id = this.dataset.id;

      //发送请求
      $.ajax({
        url: 'post/postDel.php',
        data:{
          id: id,
          cateid: cateid
        },
        dataType: 'json',
        success: function(res){

          var maxPage = Math.ceil(res.total / 10);

          if(maxPage < currentPage){
            currentPage = maxPage;
          }
          
          render(currentPage, cateid);

          setPage(currentPage, cateid);
        }
      })
       

     })

     //编辑功能
     // 给编辑窗口添加功能
    //  1. 富文本编辑器
    var E = window.wangEditor;
    var editor = new E('#content-box');
    //富文本编辑里面的内容发生变化,触发
    editor.customConfig.onchange = function(html){
      $('#content').val(html);
    }
    editor.create();
    //2. 别名同步
    $('#slug').on('input', function(){
      $('#strong').text(this.value || 'slug');
    })

    //3. 图片预览
    $('#feature').on('change', function(){
      if(this.files.length == 0){
          return;
      }
      // 预览图片
      $('#img').show().attr('src', URL.createObjectURL(this.files[0]));
    })

    //渲染分类
    $.ajax({
      url: 'cate/cateGet.php',
      dataType: 'json',
      success: function(res){
        // console.log(res);
        var htmlstr = template('catelist', {list: res})
        $('#category').html(htmlstr);
      }
    })
    //状态渲染
    var state = {
       drafted: '草稿',
       published: '已发布',
       trashed: '回收站'
    }
    var htmlstr = template('statuslist', {list: state})
    $('#status').html(htmlstr);

    //点击编辑按钮之后的逻辑
    $('tbody').on('click', '.btn-update', function(){
      //获取指定的一条文章数据
      $.ajax({
        url: 'post/postGetOne.php',
        data: {
          id: this.dataset.id
        },
        dataType: 'json',
        success: function(res){
          // console.log(res);
          // title添加数据
          $('#title').val(res[0]['title']);
          //富文本编辑器
          $('#content').val(res[0]['content']);
          editor.txt.html(res[0]['content']);
          //别名
          $('#slug').val(res[0]['slug']);
          $('#strong').text(res[0]['slug']);

          //图片展示
          $('#img').show().attr('src', res[0]['feature']);

          //给分类设置值
          // 以前: 给下拉列表设置默认选项,是找到对应的option,然后添加selected属性
          // 现在: 直接给select标签的value属性赋值,值和option的value值相同,则对应option会选中
          $('#category').val(res[0]['category_id']);

          //状态
          $('#status').val(res[0]['status']);

          //设置时间
          $('#created').val(moment(res[0]['created']).format('YYYY-MM-DDTHH:mm'));

          $('.edit-box').show();

          //为了实现修改数据,在这里给隐藏域的value属性添加值
          // 这个值就是当前数据的id
          $('#id').val(res[0]['id']);
        }
      })

    })

    //点击修改按钮,上传数据给服务器
    $('#btn-update').on('click', function(){
      $.ajax({
        url: 'post/postUpdate.php',
        type: 'post',
        data: new FormData($('#editForm')[0]),
        processData: false,
        contentType: false,
        success: function(){
          //刷新页面
          //传true,就是强制刷新
          location.reload(true);
        }
      })
    })

    $('#btn-cancel').on('click', function(){
      $('.edit-box').hide();
    })


    //================================================================================


    // 独立完成部分: 
    // 1. 动态渲染下拉窗口
    $.ajax({
      url: 'cate/cateGet.php',
      dataType: 'json',
      success: function(res){

        var htmlstr = template('catefilterlist', {list: res});
        $('#filter').html(htmlstr);
      }
    })

    //2. 给下拉框,注册事件
    $('#filter').on('change', function(e){
    // $('#filter option:selected'); //获取到被选中的option
      cateid = $('#filter option:selected').val(); //获取到对应的category_id
      render(1, cateid);
      setPage(1, cateid);
    })


    //渲染列表
    render(1,0);
    function render(page, cateid){
      $.ajax({
        url: 'post/postFilterGet.php',
        type: 'get',
        data: {
          cateid: cateid,
          page: page
        },
        dataType: 'json',
        success: function(res){
          var obj = {
           list: res,
           status: state
          }

          var htmlstr = template('postlist', obj);
          $('tbody').html(htmlstr);
        }
      })
    }

    //渲染分页
    setPage(1,0);
    function setPage(page, cateid){
        $.ajax({
          url: 'post/postFilterTotal.php',
          data:{
            cateid: cateid
          },
          dataType: 'json',
          success: function(res){
            $('#paginationBox').pagination(res.total,{
                prev_text: '上一页',
                next_text: '下一页',
                items_per_page: 10, //默认值是10
                num_edge_entries: 1,
                num_display_entries: 2,
                current_page: page - 1, //控制那个页码高亮 是索引
                load_first_page: false, //控制初始化时,回调函数是否被执行,默认是true, 会执行, false 则是不会执行
                //是点击页码的时候会触发的会调函数
                // 注意:初始化分页插件的时候,也会被触发
                callback: function(index){
                  // index是我们点击的页码的下

                  currentPage = index + 1;
                  render(index + 1, cateid);

                }
            })   
          }
      })
     }










  
  
  
  
  </script>






</body>
</html>

<?php
  include_once '../fn.php';
  isLogin();

  $page = 'comments';


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include 'inc/nav.php'?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch btn-all" style="display: none">
          <button class="btn btn-info btn-sm btn-all-approved">批量批准</button>
          <button class="btn btn-danger btn-sm btn-all-del">批量删除</button>
        </div>
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
            <th class="text-center" width="40"><input type="checkbox" class="allcheck"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-warning btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-warning btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

 
  <?php include 'inc/aside.php'?>
  

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>

  <script type="text/template" id="comlist">
      {{each list v}}
        <tr>
            <td class="text-center"><input type="checkbox" class="onechecked" data-id={{v.id}} data-haha="123"></td>
            <td>{{v.author}}</td>
            <td>{{v.content.substr(0,20)}}...</td>
            <td>《{{v.title}}》</td>
            <td>{{v.created}}</td>
            <td>{{status[v.status]}}</td>
            <td class="text-right">
            {{if v.status == 'held'}}
              <a href="javascript:;" class="btn btn-info btn-xs btn-approved" data-id="{{v.id}}">批准</a>
            {{/if}}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del" data-id="{{v.id}}">删除</a>
            </td>
        </tr>

      {{/each}}
  
  </script>

  <script>

    var currentPage = 1; // 用来存储当前展示的是哪一页
    // 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）
    var state = {
      held: '待审核',
      approved: '准许',
      rejected: '拒绝',
      trashed: '回收站'
    }
    //发送ajax请求,获取评论的数据
    render(currentPage);
    function render(page){
      $.ajax({
      url: 'com/comGet.php',
      type: 'get',
      data:{
        page: page
      },
      dataType: 'json',
      success:function(res){
        // console.log(res);

        var obj = {
          list: res,
          status: state
        }

       var htmlstr =  template('comlist', obj);
       $('tbody').html(htmlstr);

       //隐藏批量按钮，取消全选
       $('.btn-all').hide();
       $('.allcheck').prop('checked', false);

       
      }
    })
    }

    //渲染分页插件
    setPage(currentPage);
    function setPage(page){
      $.ajax({
      url: 'com/comTotal.php',
      dataType: 'json',
      success:function(res){
        // console.log(res);
          $('#paginationBox').pagination(res.total,{
            prev_text: '上一页',
            next_text: '下一页',
            items_per_page:10, //默认值是10
            num_edge_entries: 1,
            num_display_entries: 3,
            current_page: page - 1, //控制那个页码高亮 是索引
            load_first_page: false, //控制初始化时,回调函数是否被执行,默认是true, 会执行, false 则是不会执行
            //是点击页码的时候会触发的会调函数
            // 注意:初始化分页插件的时候,也会被触发
            callback: function(index){
              // index是我们点击的页码的下标
      

              //注意: 由于currentPage要和当前展示的页数永远保持一致,所以当页数发生变化的变化的也要给currentPage重新赋值
              currentPage = index + 1;
              // console.log(index);
              render(index + 1);
            }
          })   
        }
      })
    }

    //批转按钮的逻辑
    // 1. 获取元素,注册事件
    // jquery中如何事件委托
    // $(父级元素的选择器).on('事件名', '具体要触发事件的子元素', 回调函数)

    $('tbody').on('click','.btn-approved', function(){
      // alert('111111');
       // 2. 在事件处理函数中发送ajax请求
       var id = $(this).attr('data-id');
       $.ajax({
         url: 'com/comApp.php',
         data:{
           id: id
         },
         success: function(){
            //重新渲染列表
            render(currentPage);
         }
       })
       // 3. 重新渲染列表

    })


    //删除按钮的逻辑
    // 1. 获取元素,注册事件
    $('tbody').on('click', '.btn-del', function(){
    // 2. 在事件处理函数中, 获取id
      var id = $(this).attr('data-id');
      // 3. 发送ajax请求
      $.ajax({
        url: 'com/comDel.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(res){

          // console.log(res);
          //根据删除之后的数据,计算可以分多少页
          var maxPage = Math.ceil(res.total / 10);

          console.log(maxPage, currentPage);

          // 如果maxPage小于currentPage的时候,说明最后一页删除完毕了
          // 需要让分页,高亮上一页, 需要让列表渲染上一页
          if(maxPage < currentPage){
            currentPage = maxPage;
          }
          
          //  // 4. 重新渲染列表
          render(currentPage);
          // 重新渲染分页
          setPage(currentPage);
        }
      })
   

    })

    // 全选复选框
    //需求： 
    // 1. 全选都选中，下面的也都选中。全选不选中，下面的都取消
    // 2. 全选都选中，批量按钮展示。全选不选中，批量按钮隐藏
    $('.allcheck').on('change', function(){

      //  1. 
      var flag = $('.allcheck').prop('checked');

      // if(flag){
      //   //下面的每一个都选中
      //   //由于是在全选的事件中获取，此时，每一个复选框一定都渲染完成了。所以肯定可以获取到
      //   $('.onechecked').prop('checked', true);

      // }else{
      //   //下面每一个都不选中
      //     $('.onechecked').prop('checked', false);
      // }
      $('.onechecked').prop('checked', flag);
      
      // 2.
      flag ? $('.btn-all').show() : $('.btn-all').hide()


    })

    //每一个单个的复选框
    // 需求：
    // 都选中，全选选中，否则隐藏
    // 两个及以上选中，批量按钮展示，否则隐藏

    $('tbody').on('change', '.onechecked', function(){

       //1. 可以获取到选中的单个复选框的长度
      var checkedNum = $('.onechecked:checked').length;
      // 2. 获取当前页面有多少个单个复选框的长度
      var oneNum = $('.onechecked').length;

      // if(checkedNum == oneNum){
      //   //全选按钮，选中
      //   $('.allcheck').prop('checked', true);
      // }else{
      //   //全选按钮，取消
      //   $('.allcheck').prop('checked', false);
      // }

      $('.allcheck').prop('checked', checkedNum == oneNum);
      

      checkedNum >= 2 ? $('.btn-all').show() : $('.btn-all').hide();

    })


    //批量批准
    // 1. 获取元素，注册事件
    $('.btn-all-approved').on('click', function(){

      // 2. 获取id，并且拼接成一个以逗号分隔的字符串
      // 2.1 获取选中的数据的id
      // console.log($('.onechecked:checked'));
      // 2.2 拼接成相隔的字符串
      var ids = getids($('.onechecked:checked'));
     

      // console.log(ids);

      // 3. 发送ajax请求，上传数据
      $.ajax({
        url: 'com/comApp.php',
        data:{
          id: ids
        },
        success: function(){
           // 4. 在成功的回调函数中，重新渲染列表
           render(currentPage);
        }
      })

     
    })

    //批量删除
    // 1. 获取元素，注册事件
    $('.btn-all-del').on('click', function(){
      // 2. 获取id，拼接字符串

      var ids = getids($('.onechecked:checked'));

      // 3. 发送ajax请求
      $.ajax({
        url: 'com/comDel.php',
        data:{
          id: ids
        },
        dataType: 'json',
        success: function(res){
           console.log(res);
            // 4. 重新渲染列表， 重新渲染分页
            var maxPage = Math.ceil(res.total / 10);
            // 如果maxPage小于currentPage的时候,说明最后一页删除完毕了
            // 需要让分页,高亮上一页, 需要让列表渲染上一页
            if(maxPage < currentPage){
              currentPage = maxPage;
            }
            render(currentPage);
            setPage(currentPage);
        }
      })
     

    })

    // 封装函数， 拼接id的函数
    // 函数的三要素： 
    // 1. 函数名  getids 
    // 2. 参数 ： 需要id, 传入要给jquery对象
    // 3. 返回值： 返回拼接后的结果

    // 总结： 
    // 如果函数中要执行异步操作，则不需要有返回值，肯定要有回调函数
    // 如果这个函数执行完，不需要结果，也不用写return
    // 如果这个函数执行的是同步的操作，并且需要结果，一定要记得写返回值

    function getids($ele){
      var arr = [];
      $ele.each(function(index, item){

        // item.getAttribute('data-id')
        // $(item).attr('data-id')
        // console.log(item.dataset); //可以获取到所有标签上使用data-xxx方式定义的属性 
        arr.push(item.dataset.id);
      })
      return arr.join(',');

    }
    




   
    
  
  
  
  </script>
</body>
</html>

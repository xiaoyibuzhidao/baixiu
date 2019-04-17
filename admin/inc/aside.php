
<?php


$postsArr = ['posts', 'categories', 'post-add'];

$ispost = in_array($page, $postsArr);

$setArr = ['settings', 'slides', 'nav-menus'];

$isset = in_array($page, $setArr);


// 需求: 获取当前登录用户的数据, 动态的展示出来

// 1. 操作数据库,获取数据  
//  1. 获取当前登录用户的id 
  // session_start();
  $id = $_SESSION['userid'];
//  2. 拼接sql语句
  $sql = "select * from users where id = $id";
//  3. 执行sql语句
  $res = my_select($sql);
// 2. 渲染




?>
<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $res[0]['avatar']?>">
      <h3 class="name"><?php echo $res[0]['nickname']?></h3>
    </div>
    <ul class="nav">
      <li class="<?php echo $page == 'index1' ? 'active' : ''?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class="<?php echo $ispost ? 'active' : ''?>">
      <!-- 有collapsed 箭头朝右, 没有就朝下-->
        <a href="#menu-posts" data-toggle="collapse" class="<?php echo $ispost ? '' : 'collapsed'?>">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <!-- 有 in 展示二级列表  没有则隐藏 -->
        <ul id="menu-posts" class="collapse <?php echo $ispost ? 'in' : ''?>">
          <li class="<?php echo $page == 'posts' ? 'active' : ''?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $page == 'post-add' ? 'active' : ''?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $page == 'categories' ? 'active' : ''?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $page == 'comments' ? 'active' : ''?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class="<?php echo $page == 'users' ? 'active' : ''?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li class="<?php echo $isset ? 'active' : ''?>">
        <a href="#menu-settings" class="<?php echo $isset ? '' : 'collapsed'?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $isset ? 'in' : ''?>">
          <li class="<?php echo $page == 'nav-menus' ? 'active' : ''?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $page == 'slides' ? 'active' : ''?>"><a href="slides.php">图片轮播</a></li>
          <li class="<?php echo $page == 'settings' ? 'active' : ''?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
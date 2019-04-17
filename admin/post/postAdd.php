<?php

    // 获取前段上传的数据,添加到数据库里
    // 1. 获取数据,变量接收 $_POST
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $feature = '';
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    session_start();
    $userid = $_SESSION['userid'];
    // 2. 存储文件到服务器中
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    $file = $_FILES['feature'];
    // 2.1 判断是否上传成功
    if($file['error'] == 0){

        // 2.2 获取后缀名
        $ext = strrchr($file['name'], '.');
        // 2.3 拼接新的文件名
        $filename = time().rand(1000, 9999).$ext;
        // 2.4 拼接新的路径
        $path = "../../uploads/$filename";
        // 2.5 存储
        move_uploaded_file($file['tmp_name'], $path);

        //为了存储图片的路径
        // 使用这个路径的时候,是在posts中使用,所以存储到数据库的路径,和存储文件的路径,层级有一点区别
        $feature = "../uploads/$filename";
    }

     // 3. 拼接sql语句
     $sql = "insert into posts (title, content, slug, feature, category_id, created, status, user_id) values ('$title', '$content', '$slug', '$feature', '$category', '$created', '$status', '$userid')";
    // 4. 引入文件,执行方法
     include_once '../../fn.php';
     my_exec($sql);

?>
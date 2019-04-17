<?php

    //修改数据

    // 获取前段上传的数据,添加到数据库里
    // 1. 获取数据,变量接收 $_POST
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $feature = '';
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $id = $_POST['id'];
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

    //判断是否上传图片. 如果上传,$feature是一个有值的字符串,sql语句中就需要修改图片的路径,否则不需要修改
    if(empty($feature)){
        // 不修改
        $sql = "update posts set title='$title', content='$content', slug='$slug', category_id=$category, created='$created', status='$status' where id=$id";
    }else{
        //修改
        $sql = "update posts set title='$title', content='$content', slug='$slug', category_id=$category, created='$created', status='$status', feature='$feature' where id=$id";
    }

    include_once '../../fn.php';
    my_exec($sql);
   



?>
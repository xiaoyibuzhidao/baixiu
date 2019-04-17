<?php

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // 接收数据,存储到数据库中

    // 1. 接收数据
    // 1.1 判断图片是否上传成功,如果不成功就不执行后面的所有代码
    $file = $_FILES['image'];
    if($file['error'] == 0){
        // 1.2 成功才接收其他数据
        $ext = strrchr($file['name'], '.');
        $filename = time().rand(1000, 9999).$ext;
        $path = "../../uploads/$filename";
        move_uploaded_file($file['tmp_name'], $path);

        $arr = [];
        $arr['image'] = "uploads/$filename";
        $arr['text'] = $_POST['text'];
        $arr['link'] = $_POST['link'];


        // 2. 获取数据库中的数据
        $sql ="select value from options where id = 10";

        include_once '../../fn.php';
        $res = my_select($sql);
    
        $result = json_decode($res[0]['value'], true);

        // // echo '<pre>';
        // // print_r($result);
        // // echo '</pre>';

        // // echo '<pre>';
        // // print_r($arr);
        // // echo '</pre>';
        // // 3. 把接收到的数据,添加到从数据库中获取的数据中
        $result[] = $arr;
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // // 4. 在存储到数据库中
        $str = json_encode($result);

        // echo $str;

        // str_replace(被替换的字符, 替换的字符, 被操作的字符串) 返回一个替换之后的新的字符串
        $str = str_replace('\\', '\\\\', $str);

        $sql = "update options set value = '$str' where id = 10";
        my_exec($sql);

    }



?>
<?php
define('MB', 1048576);
session_start();
require_once('connection.php');

$title = $_POST['post_title'];
$des = $_POST['des'];


$path_arr = array();

for($i = 0; $i < count($_FILES['file']['name']); $i++){
    array_push($path_arr,$_FILES['file']['name'][$i]);
}
for($i = 0; $i < count($_FILES['file']['size']); $i++){
    if($_FILES['file']['size'][$i] > 100*MB){
        $_SESSION['msg_err'] = 'Какой-то из файлов весит больше чем 100MB!';
        header('Location: ../index.php');
    }
}
for($i = 0; $i < count($path_arr); $i++){
    if(end(explode(".", $path_arr[$i])) != 'zip' && end(explode(".", $path_arr[$i])) != 'doc' && end(explode(".", $path_arr[$i])) != 'docx' &&
        end(explode(".", $path_arr[$i])) != 'xls' && end(explode(".", $path_arr[$i])) != 'xlsx' &&
        end(explode(".", $path_arr[$i])) != 'pdf' && end(explode(".", $path_arr[$i])) != 'jpg' && end(explode(".", $path_arr[$i])) != 'png'){
        $_SESSION['msg_err'] = 'Допустимые типы файлов:  *.zip, *.doc, *.docx, *.xls, *.xlsx, *.pdf, *.jpg, *.png!';
        header('Location: ../index.php');
        exit();
    }
}
$date = date('Y-m-d');
$post_id = rand(0,1000000);
$query = 'insert into posts(user_id,post_id,title,description,date) values(?,?,?,?,?)';
$qr = $connection->prepare($query);
$qr->execute([$_SESSION['user']['id'],$post_id,$title,$des,$date]);
for($i = 0; $i < count($path_arr); $i++){
    $path_arr[$i] = 'uploads/' . time() . $path_arr[$i];
}
for($i = 0; $i < count($_FILES['file']['name']); $i++){
    if(!move_uploaded_file($_FILES['file']['tmp_name'][$i],'../' . $path_arr[$i])){
        $_SESSION['msg_err'] = 'Ошибка при загрузки изображения!';
        header('Location: ../index.php');
        exit();
    }
}

for($i = 0; $i < count($path_arr); $i++){
    if($i == 0) {
        $avatar .= $path_arr[$i];
    }else{
        $avatar .= '||'.$path_arr[$i];
    }
}

$query = 'INSERT INTO list_of_posts(
	user_id, post_id, path)
	VALUES (?, ?, ?)';
$qr = $connection->prepare($query);
    $qr->execute([$_SESSION['user']['id'],$post_id,$avatar]);
$_SESSION['msg_suc'] = 'Пост добавлен!';
header('Location: ../index.php');

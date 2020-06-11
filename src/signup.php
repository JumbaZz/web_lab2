<?php
session_start();
require_once('connection.php');
define('MB', 1048576);
$name = $_POST['name'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_con = $_POST['password_con'];
$avatar_r = end(explode(".", $_FILES['avatar']['name']));
$query= 'select * from users where login = ? or email = ?';
$qr = $connection->prepare($query);
$qr->execute([$login,$email]);
if($qr->rowCount() > 0){
    $_SESSION['msg_err'] = 'Такой логин или почта уже существуют';
    header('Location: ../index.php');
    exit();
}

if($password == $password_con){
    if($_FILES['avatar']['name'] == null){
        $avatar = '../img/noavatar.png';
} else{
        $avatar = 'uploads/' . time() . $_FILES['avatar']['name'];
        if($avatar_r != 'jpg' && $avatar_r != 'png'){
            $_SESSION['msg_err'] = 'Неправильный формат изображения! Используйте *.png или *.jpg';
            //header('Location: ../index.php');
            exit();
        }
        if(!move_uploaded_file($_FILES['avatar']['tmp_name'],'../' . $avatar)){
            $_SESSION['msg_err'] = 'Ошибка при загрузки изображения!';
            header('Location: ../index.php');
            exit();
        }
        if($_FILES['avatar']['size'] > 100*MB){
            $_SESSION['msg_err'] = 'Слишком большой размер изображения! Максимально 100MB';
            header('Location: ../index.php');
            exit();
        }
    }
$query = 'INSERT INTO users(
	name, login, email, password, avatar)
	VALUES (?, ?, ?, ?, ?);';
$qr = $connection->prepare($query);
$qr->execute([$name,$login,$email,md5($password),$avatar]);
    $_SESSION['msg_suc'] = 'Регистрация прошла успешно!';
    header('Location: ../index.php');
} else{
    $_SESSION['msg_err'] = 'Пароли не совпадают!';
    header('Location: ../index.php');
}
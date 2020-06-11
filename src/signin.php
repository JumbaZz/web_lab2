<?php
session_start();
require_once('connection.php');
$email = $_POST['email'];
$password = $_POST['password'];
$qr = $connection->prepare('select * from users where email = ? and password = ?');
$qr->execute([$email,md5($password)]);
$res_user = $qr->fetch(PDO::FETCH_ASSOC);
$count_user = $qr->rowCount();
if ($count_user > 0){
    $_SESSION['user']['login'] = $res_user['login'];
    $_SESSION['user']['id'] = $res_user['user_id'];
    $_SESSION['msg_suc'] = 'Вы вошли!';
    header('Location: ../index.php');
}  else{
    $_SESSION['msg_err'] = 'Неправильный логин или пароль!';
    header('Location: ../index.php');
}
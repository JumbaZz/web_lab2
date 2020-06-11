<?php
session_start();
if($_SESSION['user']){
    $a = true;
}
require_once('src/connection.php');
$query = 'select * from posts as p inner join list_of_posts as lp on p.post_id=lp.post_id
left join users as u on u.user_id = p.user_id ';
$qr = $connection->query($query);
$count = $qr->rowCount();
$res = $qr->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="message">
    <?php
    if($_SESSION['msg_suc']){
        echo '<p class="msg_suc">' . $_SESSION['msg_suc'] . '</p>';
    }
    unset($_SESSION['msg_suc']);
    if($_SESSION['msg_err']){
        echo '<p class="msg_err">' . $_SESSION['msg_err'] . '</p>';
    }
    unset($_SESSION['msg_err']);
    ?>
</div>
<?php
if(!$a){
    echo '<header>
    <div class="btn-group dropleft action-index">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </button>
        <div class="dropdown-menu">
            <button class="dropdown-item signin-btn">Войти</button>
            <button class="dropdown-item signup-btn">Зарегистрироваться</button>
        </div>
    </div>
</header>';
}
else{
    echo '<header>
    <div class="btn-group dropleft action-index">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </button>
        <div class="dropdown-menu">
            <a href="profile.php" class="dropdown-item">Профиль</a>
            <button class="dropdown-item btn-post">Выложить пост</button>
            <a href="src/logout.php" class="dropdown-item">Выйти</a>
        </div>
    </div>
</header>

';
}
if($count > 0) {
    echo '<table class="table">
<thead>
<tr>
<th>Название</th>
<th>Дата добавления</th>
<th>Описание</th>
<th>Автор</th>
<th>Файлы</th>
</tr>
</thead>
<tbody>
';
    for ($i = 0; $i < $qr->rowCount(); $i++) {
        echo '<tr>
    <td>' . $res[$i]['title'] . '</td>
    <td>' . date('m.d.Y', strtotime($res[$i]['date'])) . '</td>
    <td>' . $res[$i]['description'] . '</td>
    <td>' . $res[$i]['login'] . '</td>
    <td>';
        $path = explode("||", $res[$i]['path']);
        foreach ($path as $p) {
            echo '<a href="' . $p . '" download>Скачать</a></br>';
        }
        echo '</td>
</tr>';
    }
    echo '</tbody>
</table>';
} else{
    echo '<p class="msg_err" style="top:50px;">Еще нет ни одного поста</p>';
}


?>
<div class="add_post none">
    <form action="src/add_post.php" class="add_post_form" method="post" enctype="multipart/form-data">
        <label for="post_title">Напишите название</label>
        <input type="text" placeholder="Название" name="post_title" class="form-control index_input1" required>
        <label for="des">Напишите описание</label>
        <textarea name="des" cols="30" rows="10" placeholder="Описание" style="resize:none" class="form-control  index_input1" required></textarea>
        <label for="file">Выберите один или несколько файлов</label>
        <input type="file" name="file[]" multiple required>
        <button type="submit" class="btn btn-success" style="width: 100px;margin: 0 170px">Выложить</button>
        <a href="index.php" class="btn-exit-post"></a>
    </form>
</div>
<div class="signin_form none">
    <form action="src/signin.php" method="post" class="signin_form1">
        <a class="btn-exit-in"></a>
    <input type="email" placeholder="Email" name="email" class="form-control  index_input" required>
    <input type="password" placeholder="Password" name="password" class="form-control  index_input" required>
    <button type="submit" class="btn">Войти</button>
    </form>
</div>
</body>
<div class="signup_form none">
    <form action="src/signup.php" method="post" class="signup_form1" enctype="multipart/form-data">
        <a class="btn-exit-up"></a>
        <input type="text" placeholder="Name" name="name" class="form-control  index_input" required>
        <input type="text" placeholder="Login" name="login" class="form-control  index_input" required>
        <input type="email" placeholder="Email" name="email" class="form-control  index_input" required>
        <input type="file" placeholder="Avatar" name="avatar">
        <input type="password" placeholder="Password" name="password" class="form-control  index_input" required>
        <input type="password" placeholder="Password Confirm" name="password_con" class="form-control  index_input" required>
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
</div>
<div class="all">

</div>
</body>
<script src="js/index.js"></script>
<script src="js/index1.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>
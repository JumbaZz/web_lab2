<?php
$connection = new PDO('pgsql:host = localhost;dbname = Disk','postgres','123');
if(!$connection){
    die('Error connect to db!');
}
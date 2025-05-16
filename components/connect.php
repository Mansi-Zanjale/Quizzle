<?php

$db_name = 'mysql:host=localhost;dbname=quiz_db;charset=utf8mb4';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password,[
    PDO::ATTR_ERRMODE=>
    PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>
    PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8mb4"
]);

?>

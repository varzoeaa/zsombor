<?php
// db config
$host = 'host';
$username = 'username';
$password = 'password';
$database = 'name';

// db csatlakozás
$con = mysqli_connect($host, $username, $password, $database);

// checking db kapcs
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
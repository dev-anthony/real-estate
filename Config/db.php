<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'auth';

//$pdo = new PDO("mysql:host=$host; username=$username", $password, $db_name);
$conn = new mysqli($host, $username, $password, $db_name);

?>
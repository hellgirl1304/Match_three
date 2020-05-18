<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	$host = 'localhost';
	$db_username = 'user';
	$password = 'user';
	$db_name = 'mtg';
	$db_charset = 'utf8';

	$dbh = new PDO("mysql:host={$host}; dbname={$db_name}", $db_username, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$log = $_POST['log'];
	$hashPass = $_POST['hashPass'];
	$text = "insert into users (dimention_key, login, password_u) values (null, '{$log}', '{$hashPass}')";
	$res = $dbh->query($text);
	echo "Зарегистрирован";
?>
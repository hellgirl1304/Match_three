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

	$id = $_POST['id'];
	$name = $_POST['name'];
	$set = $_POST['set'];
	$numberCard = $_POST['numberCard'];
	$text = "insert into user_card (id_card, d_user, number_card) values ((select distinct id_card from card_by_set where name like '{$name}' and set_code like '{$set}'), '{$id}', '{$numberCard}')";
	$res = $dbh->query($text);
	echo "Добавлено";
?>
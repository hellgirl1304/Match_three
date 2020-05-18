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
	$text1 = "select count(*) cnt from (select dimention_key from users where login = '{$log}') tab";
	$res = $dbh->query($text1);
	$res=$res->fetchAll();
	foreach ($res as $key => $value) {
				$num = "{$value[0]}";
			
	}
	echo "$num";
?>
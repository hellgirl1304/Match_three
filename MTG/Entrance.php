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
	$text1 = "select dimention_key from users where login = '{$log}' and password_u = '{$hashPass}'";
	$res = $dbh->query($text1);
	$res=$res->fetchAll();
	if ($res != null) {
		foreach ($res as $key => $value) {
			$num = "{$value[0]}";
		}
		echo "$num";
	}
	else {
		echo "0";
	}

?>
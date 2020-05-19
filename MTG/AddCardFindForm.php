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

	//$text = "insert into users (dimention_key, login, password_u) values (null, '{$log}', '{$hashPass}')";
	//$res = $dbh->query($text);
	echo "<h1 class='AllForm'>Добавить карту</h1>
		
			<input type='text' id ='AllCard' list='cars' />
			<datalist id='cars'>
  			<option>Volvo2</option>
  			<option>Saab2</option>
			</datalist>
			<span id='errmsg'></span>
			<a class='TextButton' id='FindCard'><ins>Искать</ins></a>";
?>
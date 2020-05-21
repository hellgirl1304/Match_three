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

	$text1 = "select count(*) cnt from user_card where d_user = '{$id}' and id_card in (select  id_card from card_by_set where name like '{$name}' and set_code like '{$set}')";
	$res = $dbh->query($text1);
	$res=$res->fetchAll();
	$num = 0;
	if ($res != null) {
		foreach ($res as $key => $value) {
			$num = $value[0];
		}
	}
	if ($num == 0) {
	$text = "insert into user_card (id_card, d_user, number_card) values ((select distinct id_card from card_by_set where name like '{$name}' and set_code like '{$set}'), '{$id}', '{$numberCard}')";
	$res = $dbh->query($text);
	}
	else {
		$text = "update user_card set number_card = (number_card+{$numberCard}) where
		id_card in (select  id_card from card_by_set where name like '{$name}' and set_code like '{$set}') and  d_user = '{$id}'";
		$res = $dbh->query($text);
	}

	echo "Добавлено";
?>
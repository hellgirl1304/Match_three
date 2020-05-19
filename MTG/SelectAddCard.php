<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	$host = 'localhost';
	$db_username = 'mysql';
	$password = 'mysql';
	$db_name = 'mtg';
	$db_charset = 'utf8';

	$dbh = new PDO("mysql:host={$host}; dbname={$db_name}", 'mysql', $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if (empty($_POST))
		$limit = 0;
	else $limit = $_POST['limit'];
	$cardName = $_POST['cardName'];

	$text = "select name 'Название карты', ru_name 'Русское название', set_code 'Сет' from card_by_set where name like '%{$cardName}%' or ru_name like '%{$cardName}%' limit {$limit}, 15";
	$res = $dbh->query($text);
		$res=$res->fetchAll();
	if ($res == null) echo "<p class=\"MainText\">По вашему запросу в таблице ничего не найдено</p><br>";
		else {
		$table = "<h2 class=\"MainText\">Найденные карты:</h2>";
		$table .= " <table class=\"table\" border=\"1\"> <thead> <tr>";
		$ind = 0;
		foreach ($res[0] as $key => $value){
			if ($ind == 0){
				$table .= "<th>{$key}</th>";
				$ind++;
			} else $ind = 0;
		}
		$table .= "</tr></thead><tbody>";
		foreach ($res as $key => $value) {
			$table .= "<tr>";
			for ($i = 0; $i < count($value)/2; $i++) {
				$table .= "<td>{$value["{$i}"]}</td>";
			}
			$table .= "</tr>";
		}
		$table .= "</tbody></table>";
		echo $table;
	
}
?>
<input type="button" id="PredPageAdd" class ="MainText" value="<="/>
 <input type="button" id="NextPageAdd" class ="MainText" value="=>"/>
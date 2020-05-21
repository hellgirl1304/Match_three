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

	$text = "select cs.name 'Название карты', cs.ru_name 'Русское название', cs.set_code 'Сет', ls.name 'Добавление' from card_by_set cs, set_list ls where (cs.name like '%{$cardName}%' or cs.ru_name like '%{$cardName}%' ) and ls.code = cs. set_code limit {$limit}, 15";
	$res = $dbh->query($text);
		$res=$res->fetchAll();
	if ($res == null) echo "<p class=\"MainText\">По вашему запросу в таблице ничего не найдено</p><br>";
		else {
		$table = "<h2 class=\"MainText\">Найденные карты:</h2>";
		$table .= " <table class=\"table\" border=\"1\"> <thead> <tr>";
		$ind = 0;
		foreach ($res[0] as $key => $value){
			if ($ind == 0 ){
				if ($ind != 3) {
					$table .= "<th>{$key}</th>";
					$ind++;
				}
			} else $ind = 0;
		}
		$table .= "</tr></thead><tbody>";
		foreach ($res as $key => $value) {
			$table .= "<tr>";
			for ($i = 0; $i < count($value)/2; $i++) {
				if ($i != 3) {
					if ($i == 2)
						$table .= "<td  title = \"{$value[3]}\">{$value["{$i}"]}</td>";
					else $table .= "<td>{$value["{$i}"]}</td>";
				}
			}
			$table .= "<td><input type=\"button\" 				id=\"AddBut{$ind}\" name=\"AddBut\" class = \"AddBut\"value=\"Добавить\" onClick = \"addCard('{$value[0]}', '{$value[2]}')\"></td></tr>";
			$ind++;
		}
		$table .= "</tbody></table>";
		echo $table;
	
}
?>
<input type="button" id="PredPageAdd" class ="MainText" value="<="/>
 <input type="button" id="NextPageAdd" class ="MainText" value="=>"/>
 
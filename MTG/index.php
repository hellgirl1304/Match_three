<!doctype html>
 <html> 
 <head> 
 	 <meta http-equiv="Content-type" content="text/html; charset=utf-8">
 	 <title>База данных "MTG"</title>
 	 <link rel="stylesheet" href="css/styles.css" type="text/css">
	
</head>
<body>
	<div class = 'LeftMenu'>
		<img src="images/Emb.jpg" width="250" height="200" alt="Эмблема сайта"> 
		<a class="LeftTitle" id="LeftTitle1" href="#">Добавить карты</a>
		<a class="LeftTitle" id="LeftTitle4" href="#">Выгрузить карты с ценами</a>
		<a class="LeftTitle" id="LeftTitle3" href="#">Подтвердить поступление</a>
		<a class="LeftTitle" id="LeftTitle2" href="#">Внести новый товар в общий список</a>
	</div>
	<div class="HighMenu">
		<a class="HighTitle" id="HighTitle1" href="#">Ваша коллекция</a>
</div>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	$host = 'localhost';
	$db_username = 'user';
	$password = 'user';
	$db_name = 'mtg';
	$db_charset = 'utf8';
try  {
	$dbh = new PDO("mysql:host={$host}; dbname={$db_name}", $db_username, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "<div class='MainBlock'><p class='MainText'>Подключение к базе прошло успешно</p></div>";
}
catch (PDOException $e){
		echo "<div class='MainBlock'><p>Произошла ошибка в подключении к базе</p></div>";
	}
?>
	<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
	<script src="/js/jquery.maskedinput.min.js"></script>
	<script src="/js/Unit.js"></script>
</body>
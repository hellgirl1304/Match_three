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
	$email = $_POST['email'];
	$hashEmail = $_POST['hashEmail'];

	// Переменная $headers нужна для Email заголовка
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <mail@example.com>\r\n";
        // Сообщение для Email
        $message = "Подтвердите Email по  ссылке: http://mtg/Confirmed.php?hash={$hashEmail}";

	$text = "insert into users (dimention_key, login, password_u, hash, email, email_conf) values (null, '{$log}', '{$hashPass}', '{$hashEmail}', '{$email}', 0)";
	$res = $dbh->query($text);

	if (mail($email, "Подтвердите Email на сайте", $message, $headers)) {
            // Если да, то выводит сообщение
            echo 'Подтвердите на почте';
        }
    else {
        // Если ошибка есть, то выводить её 
        echo $error; 
    }
	//echo "Зарегистрирован";
?>
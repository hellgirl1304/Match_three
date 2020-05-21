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

	$log = $_REQUEST['RegLogin'];
	$hashPass = '111222';
	$email = $_REQUEST['RegEmail'];
	$hashEmail ='111222hhh';

	// Переменная $headers нужна для Email заголовка
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <mail@example.com>\r\n";
        // Сообщение для Email
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы подтвердить Email, перейдите по <a href="http://mtg/сonfirmed.php?hash=' . $hashEmail . '">ссылка</a></p>
                </body>
                </html>
                ';

	$text = "insert into users (dimention_key, login, password_u) values (null, '{$log}', '{$hashPass}')";
	$res = $dbh->query($text);

	if (mail($email, "Подтвердите Email на сайте", $message, $headers)) {
            // Если да, то выводит сообщение
            echo 'We send email';
        }
    else {
        // Если ошибка есть, то выводить её 
        echo $error; 
    }
	//echo "Зарегистрирован";
?>
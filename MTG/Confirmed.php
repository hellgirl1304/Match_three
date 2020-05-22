<!doctype html>
 <html> 
 <head> 
     <meta http-equiv="Content-type" content="text/html; charset=utf-8">
     <title>База данных "MTG"</title>
     <link rel="stylesheet" href="css/styles.css" type="text/css">
    
</head>
<body>
  <div id="my_modal" class="modal">
    <div class="modal_content">
      <span class="close_modal_window">×</span>
      <div id = "modal_text">
        <p>Модальное окно!</p>
       </div>
    </div>
  </div>

    <div class = 'LeftMenu'>
        <img src="images/Emb.jpg" width="250" height="200" alt="Эмблема сайта"> 
    </div>
    <div class="HighMenu">
        </div>
    </div>


    <div class="MainBlock"><div class="MainText">
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

    $hash = $_GET['hash'];
    $text = "select dimention_key from users where hash = '{$hash}' and email_conf = 0";
        $res = $dbh->query($text);
        $res=$res->fetchAll();
 
    // Проверка есть ли хеш
    if ($res != null) {
        $id = "";
        foreach ($res as $key => $value) {
         $id = $value[0];
         //Подтверждаем
          $text1 = "update users set email_conf = 1 where dimention_key = '{$id}'";
            $res = $dbh->query($text1);
                echo "<p class =\"MainText\">Email подтверждён</p>";
            }
        } 
     else {
        echo "Что то пошло не так";
    }
?>
<p></p>
         <a href="index.php" class ="MainText">Вернуться на сайт</a>
        </div>
        </div>
</body>


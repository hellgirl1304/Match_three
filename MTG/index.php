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
		<a class="LeftTitle" id="LeftTitle1" href="#">Добавить карты</a>
		<a class="LeftTitle" id="LeftTitle2" href="#">Выгрузить карты с ценами</a>
	</div>
	<div class="HighMenu">
		<a class="HighTitle" id="HighTitle1" href="#">Ваша коллекция</a>
	<div class="Exit">
		<a  id="Exit" href="#">Выход</a>
		</div>
	</div>


	<div class="MainBlock"><div class="MainText">
		<h1 class='AllForm'>Вход</h1>
			<input style="width: 150px; height: 25px;" id="Login" name="Login" class="FormToy" maxlength="255" placeholder="Логин"required/>
			<p></p>
			<input type="password" style="width: 150px; height: 25px;" id="Password" name="Password" class="FormToy" maxlength="255" placeholder="Пароль"required/>
			<p></p>
			<a class="TextButton" id="Enter"><ins>Войти</ins></a>
			<p></p>
			<a class="TextButton" id="Registr"><ins>Зарегистрироваться</ins></a>
		</div>
		</div>

	<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
	<script src="/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.2.0/sha512.js"></script>
	<script src="/js/Unit.js"></script>
</body>
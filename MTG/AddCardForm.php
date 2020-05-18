	<div class="MainText">
		<h1 class='AllForm'>Добавить карту</h1>
			<input style="width: 150px; height: 25px;" id="RegLogin" name="RegLogin" class="FormToy" maxlength="255" placeholder="Название"required/><span style="color: #d41313;"> *</span>
			<p></p>
			<input type="password" style="width: 150px; height: 25px;" id="RegPassword" name="RegPassword" class="FormToy" maxlength="255" placeholder="Пароль"required/><span style="color: #d41313;"> *</span>
			<input type="text" id ="AllCard" list="cars" />
			<datalist id="cars">
  			<option>Volvo</option>
  			<option>Saab</option>
  			<option>Mercedes</option>
  			<option>Audi</option>
			</datalist>
			<span id="errmsg"></span>
			<a class="TextButton" id="Registration"><ins>Зарегистрироваться</ins></a>
		</div>

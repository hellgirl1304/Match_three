var limit = 0;
var id = 0;

$("#HighTitle1").click(function (e) {
            e.preventDefault();
             $.post("../ShowTableAllCard.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});

});

$("#LeftTitle1").click(function (e) {
            e.preventDefault();
            $.post("../EntranceForm.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});

});

//Переход на регистрацию
$(document).on('click', '#Registr', function(e) {
	e.preventDefault();
	$.post("../RegistrationForm.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});
});

//Щелчок на кнопку "Зарегистрироваться" внутри регистрации
$(document).on('click', '#Registration', function(e) {
	var log = $('#RegLogin').val();
	var pass = $('#RegPassword').val();
	var cons = $('#RegConsent').val();
	e.preventDefault();
	if (log != '' && pass != '' && ($('#RegConsent').is(':checked'))) {
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update(pass);
		var hashPass = shaObj.getHash("HEX");
		//alert (log+" "+pass+" "+hashPass);
		// Проверка, нет ли пользователя с таким логином
		$.post("../RegistrationCheck.php",{log: log}).done(
			function(result){
				if (result == '0') {
				// Регистрация
					$.post("../Registration.php",{log: log,hashPass: hashPass}).done(
						function(result){
							$.post("../SuccessfulReg.php").done(function(result){
							$("div.MainBlock").empty().append(result);
						});
					}).fail(function(error) {
				console.log(error.message);
				});
				}
				else {
					alert("Пользователь с таким логином уже есть");
				}
			}).fail(function(error) {
				console.log(error.message);
			});
	}
	else alert("Необходимо заполнить все поля, отмеченные *");
});

//Вход
$(document).on('click', '#Enter', function(e) {
	var log = $('#Login').val();
	var pass = $('#Password').val();
	e.preventDefault();
	if (log != '' && pass != '') {
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update(pass);
		var hashPass = shaObj.getHash("HEX");
		$.post("../Entrance.php",{log: log, hashPass:hashPass}).done(
			function(result){
				//Если вернули 0, то что-то неверно в пароле изи логине
				if (result == 0) {
					alert("Неверный логин или пароль");
				}
				else {	
					alert("Успешно");
					id = result;
				}
			}).fail(function(error) {
				console.log(error.message);
			});
	}
	else alert("Введите логин и пароль");
});

$(document).on('click', '#NextPage', function(e) {
	//var limit = '<?php echo $limit;?>';
//	var number = $('#NumberSaleToy').val();
	e.preventDefault();
	limit = limit + 15;
	$.post("../ShowTableAllCard.php",{limit: limit}).done(function(result)
	{
		$("div.MainBlock").empty().append(result);
	}).fail(function(error) {
		console.log(error.message);
	});
//	if (id != '' && number != '') {
//		$.post("../SaleToy.php",{id: id, number: number}).done(
//			function(result){
//				alert(result);
	//			if (result != 'Продажа невозможна, не хватает товара на складе'){
		//		$.post("../FormSaleToy.php").done(function(result){
//				$("div.MainBlock").empty().append(result);
//		}).fail(function(error) {
//				console.log(error.message);
//			});}
//			}).fail(function(error) {
//				console.log(error.message);
//			});
//		alert ("Продажа успешно выполнена")
	//}
	//alert(limit);
});
var limit = 0;
var id = 0;
var lastCardName = "";

$("#HighTitle1").click(function (e) {
            e.preventDefault();
             $.post("../ShowTableAllCard.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});

});

$("#LeftTitle1").click(function (e) {
            e.preventDefault();
			if (id == 0) {
				$.post("../EntranceForm.php").done(function(result){
					$("div.MainBlock").empty().append(result);
				});
			}
			else {
				$.post("../AddCardForm.php").done(function(result){
					$("div.MainBlock").empty().append(result);
				});
			}
});

//$(document).on('keyup', '#AllCardFind', function(e) {
	//var Value = $('#AllCardFind').val();
	//$.post("../AddCardFindForm.php").done(function(result)
		//			{
			//			$("div.MainBlock").empty().append(result);
				//		var cList = document.querySelector("#Options");
    //cList.remove(0);
		//			}).fail(function(error) {
			//			console.log(error.message);
				//	});
    //alert(Value);
//});

//Поиск добавляемой карты
$(document).on('click', '#FindCard', function(e) {
	var cardName = $('#AllCardFind').val();
	limit = 0;
	lastCardName = cardName;
	e.preventDefault();
	$.post("../SelectAddCard.php",{limit:limit, cardName: cardName}).done(function(result){
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
				//Если вернули 0, то что-то неверно в пароле или логине
				if (result == 0) {
					alert("Неверный логин или пароль");
				}
				else {	
					id = result;
					localStorage.setItem("id_user", id);
					$.post("../MyCollection.php",{limit: limit}).done(function(result)
					{
						$("div.MainBlock").empty().append(result);
					}).fail(function(error) {
						console.log(error.message);
					});
					
				}
			}).fail(function(error) {
				console.log(error.message);
			});
	}
	else alert("Введите логин и пароль");
});

$(document).on('click', '#PredPageAdd', function(e) {
	e.preventDefault();
	var cardName = lastCardName;
	if (limit >= 15) {
		limit = limit - 15;
		$.post("../SelectAddCard.php",{limit:limit, cardName: cardName}).done(function(result)
		{
			$("div.MainBlock").empty().append(result);
		}).fail(function(error) {
			console.log(error.message);
		});
	}
});
	
$(document).on('click', '#NextPageAdd', function(e) {
	e.preventDefault();
	limit = limit + 15;
	var cardName = lastCardName;
	$.post("../SelectAddCard.php",{limit:limit, cardName: cardName}).done(function(result)
	{
		$("div.MainBlock").empty().append(result);
	}).fail(function(error) {
		console.log(error.message);
	});
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

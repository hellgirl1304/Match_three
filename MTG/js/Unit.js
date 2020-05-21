var limit = 0;
var lastCardName = "";

var modal = document.getElementById("my_modal");
 var btn = document.getElementById("btn_modal_window");
 var span = document.getElementsByClassName("close_modal_window")[0];

 span.onclick = function () {
    modal.style.display = "none";
 }

 window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//Загрузка страницы
$(document).ready(function(){
	var id = localStorage.getItem("id_user");
	//alert(id);
	if (id != null) {
	//Если id сохранен, то перенаправляем на коллекцию
	$.post("../MyCollection.php", {limit: limit, id:id}).done(function(result){
		$("div.MainBlock").empty().append(result);
	});
	}
	else {
		$.post("../Exit.php").done(function(result){
			$("div.MainBlock").empty().append(result);
		});
	}
	//alert (id);
	//alert("Загрузка");
});

// Переход в коллекцию пользователя
$("#HighTitle1").click(function (e) {
            e.preventDefault();
			var id = localStorage.getItem("id_user");
			if (id != null) {
             $.post("../MyCollection.php",{limit: limit, id:id}).done(function(result){
				$("div.MainBlock").empty().append(result);
			});
			}
			else {
				$.post("../Exit.php").done(function(result){
				$("div.MainBlock").empty().append('<p class=\'DopText\'>Необходимо войти</p>'+result);
			});
			}

});

$("#LeftTitle1").click(function (e) {
            e.preventDefault();
			var id = localStorage.getItem("id_user");
			if (id != null) {
				$.post("../AddCardForm.php").done(function(result){
					$("div.MainBlock").empty().append(result);
				});
			}
			else {
				$.post("../Exit.php").done(function(result){
				$("div.MainBlock").empty().append('<p class=\'DopText\'>Необходимо войти</p>'+result);
			});
			}
});

// Переход в коллекцию с ценами
$("#LeftTitle2").click(function (e) {
            e.preventDefault();
			var id = localStorage.getItem("id_user");
			if (id != null) {
             $.post("../MyCollectionWithCost.php",{limit: limit, id:id}).done(function(result){
				$("div.MainBlock").empty().append(result);
			});
			}
			else {
				$.post("../Exit.php").done(function(result){
				$("div.MainBlock").empty().append('<p class=\'DopText\'>Необходимо войти</p>'+result);
			});
			}

});

//Поиск добавляемой карты
$(document).on('click', '#FindCard', function(e) {
	var cardName = $('#AllCardFind').val();
	limit = 0;
	if (cardName != "") {
		lastCardName = cardName;
		e.preventDefault();
		$.post("../SelectAddCard.php",{limit:limit, cardName: cardName}).done(function(result){
				$("div.MainBlock").empty().append(result);
			});
	}
	else alert ("Вы ничего не ввели");
});


//Добавление карты
 function addCard(name, set) {
	modal.style.display = "block";
	document.getElementById("modal_text").innerHTML = '<p>Добавить '+name +' из сета ' + set + '</p>';
	document.getElementById("modal_text").innerHTML += '<p>Введите количество копий</p>';
	document.getElementById("modal_text").innerHTML += '<input style="width: 100px; height: 25px;" id="NumberCard" name="NumberCard" class="FormToy" maxlength="255" placeholder="Количество"/>';
	document.getElementById("modal_text").innerHTML += '<p></p><input type="button" id="AddThisCard" onClick = "addCardInDB(\''+name+'\',\''+set+'\')" class ="FormToy" value="Добавить"/>';
}

//Вставка выбранной карты в базу данных
function addCardInDB (name, set) {
	var numberCard = $('#NumberCard').val();
	if(!numberCard.match(/^\d+$/)){
        alert('Неверно введено количество');
    }else{
		var id = localStorage.getItem("id_user");
       $.post("../AddCardInDB.php",{id: id, name:name, set:set, numberCard:numberCard}).done(function(result){
			document.getElementById("modal_text").innerHTML = '<p>' +result+'</p>';
		});
    }
	//alert (name+numberCard);
	
}

//Переход на регистрацию
$(document).on('click', '#Registr', function(e) {
	e.preventDefault();
	$.post("../RegistrationForm.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});
});

//Щелчок на Выход
$(document).on('click', '#Exit', function(e) {
	e.preventDefault();
	localStorage.removeItem("id_user");
	$.post("../Exit.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});
});

//Щелчок на кнопку "Зарегистрироваться" внутри регистрации
$(document).on('click', '#Registration', function(e) {
	var log = $('#RegLogin').val();
	var pass = $('#RegPassword').val();
	var cons = $('#RegConsent').val();
	var email = $('#RegEmail').val();
	var now = new Date();
	e.preventDefault();
	if (log != '' && pass != '' && ($('#RegConsent').is(':checked'))) {
		var shaObj = new jsSHA("SHA-512", "TEXT");
		shaObj.update(pass);
		var hashPass = shaObj.getHash("HEX");
		//alert (log+" "+pass+" "+hashPass);
		// Проверка, нет ли пользователя с таким логином
		$.post("../RegistrationCheck.php",{log: log, email:email}).done(
			function(result){
				if (result == '0') {
				// Регистрация
				shaObj.update(email+now);
				var hashEmail = shaObj.getHash("HEX");
					$.post("../Registration.php",{log: log,hashPass: hashPass, email:email, hashEmail:hashEmail}).done(
						function(result){
							$("div.MainBlock").empty().append(result);
							$.post("../SuccessfulReg.php").done(function(result){
							$("div.MainBlock").empty().append(result);
						});
					}).fail(function(error) {
				console.log(error.message);
				});
				}
				else {
					alert("Пользователь с таким логином и с такой почтой уже есть");
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
					var id = result;
					//alert(id);
					localStorage.setItem("id_user", id);
					$.post("../MyCollection.php",{limit: limit, id:id}).done(function(result)
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
	


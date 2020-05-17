var limit = 0;
var id = 1;

$("#HighTitle1").click(function (e) {
            e.preventDefault();
             $.post("../ShowTableAllCard.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});

});

$("#LeftTitle1").click(function (e) {
            e.preventDefault();
            $.post("../Entrance.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});

});


$(document).on('click', '#Registr', function(e) {
	e.preventDefault();
	$.post("../Registration.php").done(function(result){
				$("div.MainBlock").empty().append(result);
			});
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
<?php

	$host = 'localhost';
	$db_username = 'mysql';
	$password = 'mysql';
	$db_name = 'mtg';
	$db_charset = 'utf8';

	$dbh = new PDO("mysql:host={$host}; dbname={$db_name}", 'mysql', $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$id = $_GET['id_user'];

	require( 'fpdf\fpdf.php' );
 	$pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);

	$text  = "SELECT us.number_card 'Количество', cs.name 'Название карты', cs.set_code 'Сет', round(cs.price*70,2) 'Цена за штуку (руб)', round(cs.price*70*us.number_card,2) 'Общая сумма' FROM user_card us, card_by_set cs 
WHERE us.id_card = cs.id_card and us.d_user = '{$id}' ";
	$res = $dbh->query($text);
		$res=$res->fetchAll();
	if ($res == null) $pdf->Cell(40,10,"You have not something card yet");
		else {
		$ind = 0;
		foreach ($res[0] as $key => $value){
			if ($ind == 0){
				$ind++;
			} else $ind = 0;
		}
		foreach ($res as $key => $value) {
			$text = "{$value[0]} x {$value[1]} ({$value[2]}) for {$value[3]} rub;";
			$pdf->Cell(40,10,"{$text}");
			$pdf->Ln();
		}
	}

	$pdf->Output(D, 'YourCollection.pdf');
	

?>


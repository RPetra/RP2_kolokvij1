<?php 
session_start();

// Provjeri je li već zamišljen slučajni broj između 1 i 100
if( !isset( $_SESSION['broj'] ) )
{
	// Slučajno generiraj broj kojeg treba pogoditi i zapamti ga u sessionu.
	$_SESSION['broj'] = rand(1, 100);
	$_SESSION['brojPokusaja'] = 0;
}

	if( isset( $_SESSION['ime'] ) ){
	// Ako je korisnik već ranije unio ime i sad ponovno pristupa
	// ovoj stranici, preusmjerit ćemo ga na zadatak3_pogodi.php
	header('Location: pogadanje_br_pogodi.php');
	exit;
}



?>


<!DOCTYPE html>
<html>
<head>
<title> RP2- Pogadanje brojeva _index </title>
<style>
	
</style>
	
</head>

<body>

	<h1>Pogadanje brojeva _index</h1>
	<h3> ZADATAK: Napišite skripte _index.php i _pogodi.php koje
			omogućavaju igranje igre ”Pogađanje brojeva”. </h3>

	<ul>
		<li>Kad korisnik prvi put dođe na stranicu zadatak3_index.php,
			skripta ga pita za ime, te generira slučajan broj X između 1 i 100.
			(Naravno, ne ispiše ga korisniku.) Skripta šalje dobivene podatke
			skripti zadatak3_pogodi.php.</li>
		<li>Skripta zadatak3_pogodi.php daje korisniku priliku da proba
			pogoditi broj. Klikom na gumb ”Pogodi”, broj se šalje istoj skripti
			koja onda ispiše je li korisnikov broj veći, manji ili jednak X.</li>
		<li>Nakon što se broj pogodi, ispisuje se prigodna čestitka.</li>
	</ul>

	<h2> FORMA: </h2>
	<form action="pogadanje_br_pogodi.php" method="post">
		<label for="ime">Unesite svoje ime (između 3 i 20 slova):</label>
		<input type="text" id="ime" name="ime" />

		<br />

		<button type="submit">Pošalji</button>
	</form> 
	

	<h2> NAPOMENE </h2>
	<ul>
		<li> ma li vec zapisani broj? ne, kad ga zatrazim ( echo($_SESSION['broj') )javi error stranica ne radi 
			</li>
			
	</ul>
	
</body>
</html>


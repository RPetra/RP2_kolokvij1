<?php
	session_start();

	// Provjeri je li već zamišljena igraca ploca
	if( !isset( $_SESSION['ploca'] ) ) {
		//$igraca_ploca[..][..] = REDAK STUPAC
		$igraca_ploca = array();
		/***************************************************************************************
		* Postupak postavljanja ploce:
		*  1. pomocu for petlje za svakom broju [1,8] dodijeljujemo dvije pozicije
		*  2. odaberimo slucajanu poziciju na koju postavljamo [0,15]
		*		stupac je jedank rezultatu cijelobrojnog dijeljenja (pozicija / 4)
		*		redak je jednak ostatku cijelobrojnog dijeljenja (pozicija / 4)
		*  3. ponovo trazimo drugu slobodnu poziciju za isti broj (isti postupak)
		*  4. ponavljamo taj postupak 8 puta.
		***************************************************************************************/
		for ($broj = 1; $broj <= 8; ++$broj) {
			$postavljen = 0;

			while($postavljen < 2){
				$pozicija = rand(0, 15);
				$stupac = intdiv ( $pozicija , 4 );
				$redak = $pozicija % 4;
				if ( !isset($igraca_ploca[$redak][$stupac])){
					$igraca_ploca[$redak][$stupac] = $broj;
					++$postavljen;
					//echo "Broju $broj didjeljena je pozicija [$redak][$stupac] <br>";
				}
			}
		}

		/******************************************************************************
		//ISPIS ZADANE IGRACE PLOCE
		for ($x = 0; $x < 4 ; $x++) {
			for ($y = 0; $y < 4; $y++) {
					echo "igraca_ploca[$x][$y] =". $igraca_ploca[$x][$y]. "<br>";
			}
		}
		*******************************************************************************/

		$_SESSION['ploca'] = $igraca_ploca;
		$_SESSION['brojPokusaja'] = 0;
		$_SESSION['pogodioPar'] = array();
		$_SESSION['pokusajPar'] = array();
	}

	if( isset( $_SESSION['ime'] ) )
	{
		// Ako je korisnik već ranije unio ime i sad ponovno pristupa
		// ovoj stranici, preusmjerit ćemo ga na zadaca_igraj.php
		header('Location: zadaca_igraj.php');
		exit;
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Prva zadaća Memory, kolegij RP2">
  <meta name="keywords" content="HTML,CSS,PHP">
  <meta name="author" content="Petra Rožić">
	<link rel="stylesheet" href="stylesheet.css">
	<title>Zadaca Memory!</title>
</head>
<body>
	<h1>Memory</h1>
	<form action="zadaca_igraj.php" method="post">
		<span for="ime">Unesite svoje ime:</span>
		<input type="text" id="ime" name="ime" />

		<br><br>

		<button class="buttons" style="background-color:#239B56;" type="submit">Zapocni igru!</button>
	</form>
</body>
</html>

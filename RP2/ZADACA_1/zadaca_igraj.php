<?php
	session_start();

/*
	//POMOCNI
	session_unset();
	session_destroy();
*/

	function izlaz (){
		session_unset();
		session_destroy();
		header( 'Location: zadaca.php' );
		exit;
	}

	if( isset( $_POST['ime'] )  ){

		// Prosljeđuje nam se ime korisnika od strane zadaca.php
		// Recimo da smije imati između 3 i 20 slova.
		if( preg_match( '/^[a-zA-Z]{3,20}$/', $_POST['ime'] ) ) {
			// Zapamti korisnikovo ime u sesiji.
			$_SESSION['ime'] = $_POST['ime'];
			unset($_SESSION['error']);
		} else {
				// Korisnikovo ime nije validno. Preusmjeri ga na pocetnu stranicu.
				izlaz ();
			}


	} else {
		if (!isset($_SESSION['ime'])){
			izlaz();


		}
	}

	if( !isset( $_SESSION['ploca'] ) )
	{
		if ( isset ( $_POST['redak_'])){
			$_SESSION['redak_'] = $_POST['redak_'];
		} else {
			izlaz();
		}

		$redak_ = $_SESSION['redak_'];

		if ( isset ( $_POST['stupac_'])){
			$_SESSION['stupac_'] = $_POST['stupac_'];
		} else {
			izlaz();
		}

		$stupac_ = $_SESSION['stupac_'];

		// ako su stupac_ i redak_ neparni tada ga vrati na početak
		if ( $redak_ % 2 !== 0 and $stupac_ % 2 !== 0){
			header( 'Location: zadaca.php' );
			$_POST['error'] = "neparnost";
			unset($_SESSION['redak_']);
			unset($_SESSION['stupac_']);
			$_SESSION['error'] = "Barem jedna vrijednost mora biti parna!";
			exit;
			//izlaz();
		}
		// ako nije postavljena ploca onda ju postavi
		/***************************************************************************************
		* Postupak postavljanja ploce:
		*  1. pomocu for petlje za svaki broj [1,$max_broj] dodijeljujemo dvije pozicije
		*  2. odaberimo slucajanu poziciju na koju postavljamo [0,$max_polja]
		*  3. ponovo trazimo drugu slobodnu poziciju za isti broj (isti postupak)
		*  4. ponavljamo taj postupak $max_broj puta.
		***************************************************************************************/
		$max_broj = $redak_ * $stupac_ / 2;
		$max_polja = $redak_ * $stupac_;

		for ($broj = 1; $broj <= $max_broj; ++$broj) {
			$postavljen = 0;
			while($postavljen < 2){
				$pozicija = rand(0, $max_polja -1);
				$stupac = intdiv ( $pozicija , $stupac_ );
				$redak = $pozicija % $stupac_;
				if ( !isset($igraca_ploca[$stupac][$redak])){
					$igraca_ploca[$stupac][$redak] = $broj;
					++$postavljen;
					//echo "Broju $broj didjeljena je pozicija [$stupac][$redak] <br>";
				}
			}
		}

		$_SESSION['ploca'] = $igraca_ploca;
		$_SESSION['brojPokusaja'] = 0;
		$_SESSION['pogodioPar'] = array();
		$_SESSION['pokusajPar'] = array();
	}

	// ako je poslan POST zahtjev te je zatrazeno sve ispocetka
	if($_POST){
	    if(isset($_POST['ispocetka'])){
				// brisemo plocu
				unset($_SESSION['ploca']);
				unset($_SESSION['redak_']);
				unset($_SESSION['stupac_']);

				// preusmjerimo ga na pocetnu stranicu
					// na pocetku stranice dolazi do analie $_SESSION
						//postavlja se nova ploća, ime postaje istoj
				// mogli smo ga preusmjeriti i na ovu stranicu
					// pa bi analizom $_SESSION ona preusmjerila na pocetnu
				header( 'Location: zadaca.php' );

	    }
	}

	// sigurno imamo $_SESSION['ime'] i $_SESSION['ploca'].
		// izvadi ih u varijable da bude lakše s njima raditi.
	$ime  = $_SESSION['ime'];
	$igraca_ploca  = $_SESSION['ploca'];
	$brojPokusaja  = $_SESSION['brojPokusaja'];
	$pogodioPar = $_SESSION['pogodioPar'];
	$pokusajPar = $_SESSION['pokusajPar'];
	$stupac_ = $_SESSION['stupac_'];
	$redak_ = $_SESSION['redak_'];

	$gotov = false;
	$error = false;
	$errorMessage = '';
	unset( $stupac_1 );
	unset( $stupac_2 );
	unset( $redak_1 );
	unset( $redak_2 );

	if( isset( $_POST['stupac_1'] ) and isset( $_POST['stupac_2'] ) and isset( $_POST['redak_1'] ) and isset( $_POST['redak_2'] ) )
	{
		// ako su poslani svi parametri koji se zahtjevaju
		$options_stupac = range (0, $stupac_ );
		$options_redak = range (0, $redak_ );

		if( filter_var( $_POST['stupac_1'], FILTER_VALIDATE_INT, $options_stupac) === FALSE
			or filter_var( $_POST['stupac_2'], FILTER_VALIDATE_INT, $options_stupac) === FALSE
			or filter_var( $_POST['redak_1'], FILTER_VALIDATE_INT, $options_redak) === FALSE
			or filter_var( $_POST['redak_2'], FILTER_VALIDATE_INT, $options_redak) === FALSE )
		{
			// ako poslani parametri nisu valjani
			$error = true;
			$errorMessage = 'Trebaš unijeti brojeve između 1 i 4.';
		} else {
			// ako su poslani parametri valjani
				// dodjelimo im varijavle
			$stupac_1 = $_POST['stupac_1'];
			$stupac_2 = $_POST['stupac_2'];
			$redak_1 = $_POST['redak_1'];
			$redak_2 = $_POST['redak_2'];

			// ako je izabrao dvije iste karte (isto pozicionirane)
			if ($redak_1 === $redak_2 and $stupac_1 === $stupac_2){
					// echo "odabrao si dvije iste karte";
					$error = true;
					$errorMessage = "Potrebno je izabrati dvije različite karte";
					unset($pokusajPar);

			} else if (isset($pogodioPar[$redak_1][$stupac_1]) or isset($pogodioPar[$redak_2][$stupac_2])){
					// ako odabere kartu koja je već pogodena
					$error = true;
					$errorMessage = "Potrebno je izabrati karte koje nisu pogođene";
					unset($pokusajPar);

			} else if ( $igraca_ploca[$redak_1][$stupac_1] === $igraca_ploca[$redak_2][$stupac_2] ){
				// ako je odabrao karte koje su jednake
				// echo "-> isti brojevi.";
				$pogodioPar[$redak_1][$stupac_1] = 1;
				$pogodioPar[$redak_2][$stupac_2] = 1;
				$_SESSION['pogodioPar'] = $pogodioPar;

				++$brojPokusaja;
				$_SESSION['brojPokusaja'] = $brojPokusaja;

				unset($pokusajPar);
				unset($_SESSION['pokusajPar']);
				// jesu li sada sve karte pogodene?
				$postoji_ne_otvorena = false;
				for ( $i = 0; $i < $redak_; ++$i)
					for ( $j = 0; $j < $stupac_; ++$j)
						if ( !isset($pogodioPar[$i][$j]) ) {
							$postoji_ne_otvorena = true;
							break;
						}
				if ( !$postoji_ne_otvorena ){
					$gotov = true;
				}

			} else if ($igraca_ploca[$redak_1][$stupac_1] !== $igraca_ploca[$redak_2][$stupac_2]){
				// ako je odabrao valjane karte ali različite
				//echo "-> razliciti brojevi.";
				unset($pokusajPar);
				$pokusajPar[$redak_1][$stupac_1] = 1;
				$pokusajPar[$redak_2][$stupac_2] = 1;
				$_SESSION['pokusajPar'] = $pokusajPar;

				++$brojPokusaja;
				$_SESSION['brojPokusaja'] = $brojPokusaja;

				/*
				//ispisuje koje pokusaje sam spremila
				for ( $i = 0; $i < 4; ++$i)
					for ( $j = 0; $j < 4; ++$j)
						if (isset($pokusajPar[$i][$j])) echo "pokusajPar[$i][$j]".$pokusajPar[$i][$j];
				*/
			}
		}
	}else if ($brojPokusaja !== 0){
		//ako nisu poslani svi parametri koji se zahtjevaju
			//stavljam ogranicenje da mi ne ispisuje kada se prvi puta otvori igra
			//ne moguce ali da se ima
		$error = true;
		$errorMessage = "Potrebno je izabrati stupac i redak dviju karata";
		unset($pokusajPar);
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
	<title>Zadaca Memory_igraj</title>

</head>
<body>
	 <!--<pre><?php
			// echo '$_SERVER:'; print_r( $_SERVER ); echo "\n";
			echo '$_GET:';    print_r( $_GET );    echo "\n";
			echo '$_POST:';   print_r( $_POST );   echo "\n";
			echo '$_SESSION:'; print_r( $_SESSION ); echo "\n";
			?>
		</pre>-->

	<h1> Memory </h1>

	<span> Igrač:</span>
		<?php echo htmlentities( $ime, ENT_QUOTES );?>

	<br>

	<span> Potez broj: </span>
		<?php echo htmlentities( $brojPokusaja, ENT_QUOTES );?>

	<br><br>

	<table>

		<?php
		//ISPIS ZADANE IGRACE PLOCE
			for ($x = 0; $x < $redak_ ; $x++) {
				echo "<tr>";
				for ($y = 0; $y < $stupac_; $y++) {
						if (isset($pogodioPar[$x][$y])) {
								echo '<td style="background-color: green">';
								echo $igraca_ploca[$x][$y];
							} else if (isset($pokusajPar[$x][$y])){
									echo '<td style="background-color: yellow">';
									echo $igraca_ploca[$x][$y];
								}else
									echo '<td style="background-color: white">';
						//echo $igraca_ploca[$x][$y];
						echo "</td>";
				}
				echo "</tr>";
			}
		?>

	</table>

	<br>

	<?php
		if( !$gotov )
		{
			?>
			<form method="post" action="zadaca_igraj.php">
				<span> Odaberi dvije karte! </span>

				<br><br>

				<label> Prva karta </label>
				<label> - stupac </label>

				<select name="stupac_1">
					<?php
						for ($x = 0; $x < $stupac_ ; $x++) {
							$pom = 1+ $x;
							echo "<option value=".$x.">". $pom ."</option>";
						}
					?>
				</select>

				<label> - redak </label>

				<select name="redak_1">
					<?php
						for ($x = 0; $x < $redak_ ; $x++) {
							$pom = 1+ $x;
							echo "<option value=".$x.">". $pom ."</option>";
						}
					?>
				</select>

				<br><br>

				<label> Druga karta </label>
				<label> - stupac </label>

				<select name="stupac_2">
					<?php
						for ($x = 0; $x < $stupac_ ; $x++) {
							$pom = 1+ $x;
							echo "<option value=".$x.">". $pom ."</option>";
						}
					?>
				</select>

				<label> - redak </label>

				<select name="redak_2">
					<?php
						for ($x = 0; $x < $redak_ ; $x++) {
							$pom = 1+ $x;
							echo "<option value=".$x.">". $pom ."</option>";
						}
					?>
				</select>

				<br><br>

				<button class="buttons" type="submit" style=" background-color: green;">
						Otkrij odabrane karte
					</button>

				<br>

				<input class="buttons" type="submit" class="button" name="ispocetka" style=" background-color: red;"
					value="Hoću sve ispočetka!"/>

				<br><br>

			</form>

			<?php
		}
	?>

	<?php
		// Provjeri poruke/errore
		if( $error ){
			echo '<span class="message">';
			echo htmlentities( $errorMessage, ENT_QUOTES );
			echo "</span>";
		}
		else if( $gotov )
		{
			echo '<span class="message">';
			echo 'Bravo! Otkrio si sve kartice iz ' . $brojPokusaja . ' pokusaja!';
			echo "</span>";
			// Završavamo sesiju.
			session_unset();
			session_destroy();
?>
			<br> <br>
			<button class="buttons" type="submit" style=" background-color:#239B56;"
				onClick="location.reload();" >
					Vrati se na početnu straniciu
				</button>
<?php
		}
	?>

</body>
</html>

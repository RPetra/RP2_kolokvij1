<?php
	session_start();

	// Provjeri je li već zamišljena igraca ploca

		//$igraca_ploca[..][..] = REDAK STUPAC
		/***************************************************************************************
		* Odlučivanje o dimenziji ploče
		*  1. po defaultu je 4*4
		*  2. može se unjeti i samo M ili N tada je druga vrijednost jednaka 4
		***************************************************************************************/


	if( isset( $_SESSION['ime'] ) and isset( $_SESSION['redak_'] ) and isset( $_SESSION['stupac_'] ) )
	{
		header('Location: zadaca_igraj.php');
		exit;
	}

	if( isset($_SESSION['error'])){
		$error_message = $_SESSION['error'];
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
		<input type="text" id="ime" name="ime"
		<?php
			if (isset ( $_SESSION['ime'])){
				echo 'value = "'. $_SESSION['ime'] . '"';
				echo 'disabled';
			}
		 ?>
		/>

		<br><br>

		<span for="ime">Unesite veličinu polja:</span>

		<input class="input_dimenzion" type="text" id="stupac_" name="stupac_" value="4"/> x
		<input class="input_dimenzion" type="text" id="redak_" name="redak_" value="4"/>

		<br><br>

		<?php
			// Provjeri poruke/errore
			if( isset($error_message)){
				echo '<span class="message">';
				echo htmlentities( $error_message, ENT_QUOTES );
				echo "</span>";
				echo "<br><br>";
			}
		?>

		<button class="buttons" style="background-color:#239B56;" type="submit">Zapocni igru!</button>
	</form>

	<!--<pre><?php
 		// echo '$_SERVER:'; print_r( $_SERVER ); echo "\n";
 		echo '$_GET:';    print_r( $_GET );    echo "\n";
 		echo '$_POST:';   print_r( $_POST );   echo "\n";
 		echo '$_SESSION:'; print_r( $_SESSION ); echo "\n";
 		?>-->
 	</pre>
</body>
</html>

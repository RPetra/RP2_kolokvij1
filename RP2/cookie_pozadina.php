<?php 
/*
	Ovo je rješenje koje ne koristi validaciju korisničkih podataka.
	Ne postavljati na internet.
*/

// .. Defaultna boja pozadine
$boja = 'white';

// .. Provjeri je li postavljen cookie, ako je - učitaj boju iz cookie-a.
if( isset( $_COOKIE['boja'] ) )
	$boja = $_COOKIE['boja'];

// .. Provjeri da li je POST-om poslana boja postavljena u textboxu
if( isset( $_POST['bojaTextbox'] ) && $_POST['bojaTextbox'] !== '' )
{
	$boja = $_POST['bojaTextbox'];
}
	// .. Provjeri da li je POST-om poslana boja postavljena u selectu
else if( isset( $_POST['bojaSelect'] ) )
{
	$boja = $_POST['bojaSelect'];
}

// .. Spremi boju u COOKIE. Ističe za 60*60*24*30 sekundi, tj. za 30 dana.
setcookie( 'boja', $boja, time()+60*60*24*30 );


?> 


 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>RP- Cookie- mjenjanje pozadine</title>
	<style>
		body { 
			background-color: 
				<?php 
					echo $boja;
				?>; 
		}
	</style>
</head>
<body>
	<h1> Cookie- mjenjanje pozadine </h1>
	
	<h3> ZADATAK: Napišite PHP skriptu koja generira web-stranicu ovako: </h3>
	<ul>
		<li>Web-stranica ima inicijalno bijelu boju pozadine.</li>
		<li>Ako je korisnik već ranije bio posjetio stranicu i promijenio joj boju
			pozadine, onda se prikazuje ta ranije odabrana boja pozadine.</li>
		<li>Na web-stranici se nalazi padajući izbornik (select) na kojem
			korisnik može odabrati nekoliko unaprijed zadanih boja.
			(Postavite neki odabir kao defaultan.)</li>
		<li>Također, nalazi se textbox u kojeg korisnik može unijeti HTML
			kod boje.</li>
		<li>Klikom su gumb submit, ponovno se poziva ista skripta koja:</li>
		<ul>
			<li>Ako je išta upisano u textbox, postavlja tu boju pozadine na
				web-stranicu.</li>
			<li>U protivnom, postavlja boju pozadine koja je odabrana u
				padajućem izborniku.</li>
		</ul>
	</ul>
	
	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<label for="bojaTextbox">
			Unesi HTML kod boje pozadine (počinje sa #):
		</label>		
		
		<input type="text" name="bojaTextbox" id="bojaTextbox" value="" />

		<br />

		<label for="bojaSelect">
			Odaberi neku boju iz padajućeg izbornika:
		</label>
		<select name="bojaSelect" id="bojaSelect">
			<option value="blue" selected>Plava</option>
			<option value="green">Zelena</option>
			<option value="yellow">Žuta</option>
			<option value="white">Bijela</option>
		</select>
		
		<br />

		<button type="reset">Resetiraj!</button>
		<button type="submit">Promijeni!</button>
	</form>
</body>
</html>
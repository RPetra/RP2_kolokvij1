<!DOCTYPE html>
<html>
<head>
<title> RP2- Niz stringova </title>
<style>
	
</style>
	
</head>

<body>

<h1>Niz stringova</h1>
<h3> ZADATAK: Napišite PHP skriptu koja: </h3>
<ul>
	<li>Slučajno generira niz od 10 stringova – nizova znakova od po 5 slova.</li>
	<li>Ispisuje generirane stringove.</li>
	<li>Sortira taj niz stringova, te ga ispisuje nakon sortiranja</li>
</ul>

	<?php
		//n = broj stringova
		//srt_len = koliko string ima slova
		$n = 10; 
		$str_len = 5;

		// .. Slucajno generiraj n stringova
		for( $i = 0; $i < $n; ++$i )
		{
			// .. Generiraj i-ti string
			$str = '';
			for( $j = 0; $j < $str_len; ++$j )
				// Zalijepi slučajno odabrano malo slovo; 
					//ord('a') = 97 = ascii vrijednost od a. 
					//Još bolje: chr( rand( ord('a'), ord('z') ) ).
					//.= -->konkatemacija
				$str .= chr( rand(0, 25) + ord('a') ); 

			$polje[$i] = $str;
		}
	?>
	
	<p>
		<b>Niz prije sortiranja: </b><br>
		<?php
			for( $i = 0; $i < $n; ++$i ){
				echo $polje[$i] . " ";
			}
		?>
	</p>
	
	<p> <b>Sortiranje ... </b></p>
	<?php
		// Sortiranje
		for( $i = 0; $i < $n; ++$i )
			for( $j = $i+1; $j < $n; ++$j )
				if( strcmp( $polje[$i], $polje[$j] ) > 0 )
				{
					$temp = $polje[$i];
					$polje[$i] = $polje[$j];
					$polje[$j] = $temp;
				}
	?>	
	
	<!-- ILI Funkcija za sortiranje -->
	<?php
		function my_sort( &$niz ) // PAZI: & je nužan!
		{
			$n = count( $niz );
			
			for( $i = 0; $i < $n; ++$i )
				for( $j = $i+1; $j < $n; ++$j )
					if( strcmp( $niz[$i], $niz[$j] ) > 0 )
					{
						$temp = $niz[$i];
						$niz[$i] = $niz[$j];
						$niz[$j] = $temp;
					}
		}
	?>
	<!-- POZIV FUNK ZA SORTIRANJE: my_sort( $polje ); -->

	<p>
		<b>Niz nakon sortiranja: </b><br>
		<?php
			for( $i = 0; $i < $n; ++$i )
				echo $polje[$i] . ' ';
		?>
	</p>
	


	<h2> NAPOMENE </h2>
	<ul>
		<li>ord(znak) vra ascii kod toga znaka</li>
			prim: 
			<?php 
				$prikaz = ord( 'a' );
				echo "ord( 'a' ) = $prikaz"
			?>		
		
		<li>znak za konkatenaciju <b>.=</b> moze biti i unutar php kad stvaramo string</li>
		<li>echo $polje[$i] . " " --> prvo izracuna var pa na nju doda razmak</li>
		<li>kako u u php stringu ispisati enter????</li>
	</ul>
</body>
</html>


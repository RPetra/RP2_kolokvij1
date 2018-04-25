<!DOCTYPE html>
<html>
<head>
<title> RP2- Tablica mnozenja </title>
<style>
	table {
		font-size: large;
		border-collapse: collapse;
	}
	td {
		height: 30px;
		width: 40px;
		text-align: center;
	}
</style>
	
</head>

<body>

<h1>Tablica mnozenja</h1>

	<?php
		echo "<table border = '1' >";
		for ($i = 0; $i <= 10; $i++){
			echo "<tr>";
			
			for ($j = 0; $j <= 10; $j++){
				if (!$i && !$j){ 
					echo "<td> * </td>";
				} else if ( !$i ){
					echo "<td> $j </td>"; 
				}else if ( !$j ){
					echo "<td> $i </td>"; 
				}else {
					$r = $i * $j; 
					echo "<td> $r </td>";
				}
			}
			echo "<tr>";

		}
		echo "</table>";
	?>
				
				
<h2> Prof rjesenje: </h2>

<?php
	$n = 10;
?>

	<table style = "border: solid 1px">
		<tr>
			<td>*</td>
			<?php 
				for( $c = 1; $c <= $n; ++$c )
					echo "<th>$c</th>";
			?>
		</tr>
		<?php 
			for( $r = 1; $r <= $n; ++$r )
			{
				echo "<tr><th>$r</th>";
				for( $c = 1; $c <= $n; ++$c )
					echo "<td>" . $r * $c . "</td>";
				echo "</tr>";
			}
		?>
	</table>
</body>
</html>

<!--PROF KOD.. USPOREDI
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Zadatak 1</title>
	<style>table, th, td { border: solid 1px; }</style>
</head>
<body>
<?php
	$n = 10;
?>

	<table>
		<tr>
			<td>*</td>
			<?php 
				for( $c = 1; $c <= $n; ++$c )
					echo "<th>$c</th>";
			?>
		</tr>
		<?php 
			for( $r = 1; $r <= $n; ++$r )
			{
				echo "<tr><th>$r</th>";
				for( $c = 1; $c <= $n; ++$c )
					echo "<td>" . $r * $c . "</td>";
				echo "</tr>";
			}
		?>
	</table>
</body>
</html> 

-->

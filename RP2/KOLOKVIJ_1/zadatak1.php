<?php
  session_start();
/*
  session_unset();
	session_destroy();
*/

  if( !isset( $_SESSION['igraca_ploca'] ) ) {
    //ako ploca nije postavljena kreiramo novu
      //$igraca_ploca[red][stupac]
    $igraca_ploca = array();
    for ($kocka = 0; $kocka < 10 ; ++$kocka) {
      $igraca_ploca[0][$kocka] = 1;
    }

    $_SESSION['igraca_ploca'] = $igraca_ploca;
    //postavljamo var br. redova kako bi znali dokle ispisujemo kasnije
    $_SESSION['br_redova'] = 1;
    $_SESSION['min_kocaka'] = 10;
    $_SESSION['max_kocaka'] = 10;
    $_SESSION['tren_kocaka'] = 10;
  }


  $br_redova = $_SESSION['br_redova'];
  $igraca_ploca = $_SESSION['igraca_ploca'];
  $tren_kocaka = $_SESSION['tren_kocaka'];

  if (isset($_POST['dodaj_kocke']) and isset($_POST['dodaj_red'])){
    //ako su postavljeni potrebni parametri
    $options_redak = range (0, $br_redova );
    $options_kocke = range (1, 11);

    if( filter_var( $_POST['dodaj_red'], FILTER_VALIDATE_INT, $options_redak) !== FALSE
        and filter_var( $_POST['dodaj_kocke'], FILTER_VALIDATE_INT, $options_kocke) !== FALSE){
      //ako je red dobro odaban..
      $dodaj_red = $_POST['dodaj_red'];
      $dodaj_kocke = $_POST['dodaj_kocke'];
      $tren_situacija = 0;
      for ($i = 0; $i < 10; $i++) {
        if (isset($igraca_ploca[$dodaj_red][$i])){
          $tren_situacija++;
        }
      }
      $suma = $tren_situacija + $dodaj_kocke;
      //echo "trenutna situacija= ".$tren_situacija. "...dodajem=".$dodaj_kocke ."== ".$suma;
      if ($suma <= 10){
        for ($i = 0; $i < $suma; $i++) {
          $igraca_ploca[$dodaj_red][$i] = 1;
        }
        $tren_kocaka += $dodaj_kocke;
      }
    }
  }

  if (isset($_POST['ukloni_kocke']) and isset($_POST['ukloni_red'])){
    $options_redak = range (0, $br_redova );
    $options_kocke = range (1, 11);
    if( filter_var( $_POST['ukloni_red'], FILTER_VALIDATE_INT, $options_redak) !== FALSE
        and filter_var( $_POST['ukloni_kocke'], FILTER_VALIDATE_INT, $options_kocke) !== FALSE){
      $ukloni_red = $_POST['ukloni_red'];
      $ukloni_kocke = $_POST['ukloni_kocke'];

      $tren_situacija=0;
      for ($i = 0; $i < 10; $i++) {
        if (isset($igraca_ploca[$ukloni_red][$i])){
          $tren_situacija++;
        }
      }
      $suma = $tren_situacija - $ukloni_kocke;
      //echo "<br> trenutna situacija= ".$tren_situacija. "...uklanjam=".$ukloni_kocke ."== ".$suma;
      if ($suma >= 0){
        for ($i = $suma; $i < $tren_situacija; $i++) {
          unset($igraca_ploca[$ukloni_red][$i]);
        }
        $tren_kocaka -= $ukloni_kocke;
      }
    }
  }


  if(isset($_POST['novi_red'])){
    $br_redova = $_SESSION['br_redova'];
    for ($i = 0; $i < 10; $i++) {
      $igraca_ploca[$br_redova][$i] = 1;
    }
    $tren_kocaka += 10;
    $br_redova++;
    $_SESSION['br_redova'] = $br_redova;
  }

  $_SESSION['igraca_ploca'] = $igraca_ploca;
  $_SESSION['tren_kocaka'] = $tren_kocaka;

  if ($_SESSION['min_kocaka'] > $tren_kocaka){
    $_SESSION['min_kocaka'] = $tren_kocaka;
  } else if ($_SESSION['max_kocaka'] < $tren_kocaka){
    $_SESSION['max_kocaka'] = $tren_kocaka;
  }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Mali Mirko igra</title>
     <style>
      th, td {
        border: solid 1px;
        text-align: center;
        font-size: 20px;
      }
      tr {
        height: 40px;
      }
      td {
        width: 40px;
      }
     </style>
   </head>
   <body>

     <!--<pre><?php
         // echo '$_SERVER:'; print_r( $_SERVER ); echo "\n";
         echo '$_GET:';    print_r( $_GET );    echo "\n";
         echo '$_POST:';   print_r( $_POST );   echo "\n";
         echo '$_SESSION:'; print_r( $_SESSION ); echo "\n";
         ?>
       </pre>-->


     <h1> KOL. 2017. 1_ZAD </h1>
     <h2> Mali Mirko igra </h2>


     <?php
        if (!isset($_POST['kraj_igre'])){

        ?>
    <table>
      <?php
         //ISPIS ploce
         for($i = 0; $i < $br_redova; $i++){
           echo "<tr>";
           for ($j = 0; $j < 10 ; $j++) {
             if (isset($igraca_ploca[$i][$j])) {
               echo '<td> K </td>';
             }
           }
           echo "</tr>";
         }
      ?>
   </table>
   <br><br>
   <form action="zadatak1.php" method="post">
     <span> Dodaj  </span>
     <input type="text" id="dodaj_kocke" name="dodaj_kocke" />
     <span> kocaka u red broj </span>
     <select name="dodaj_red">
       <?php
         for ($x = 0; $x < $br_redova ; $x++) {
           $pom = 1+ $x;
           echo "<option value=".$x.">". $pom ."</option>";
         }
       ?>
     </select>

     <br><br>

     <span> Ukloni  </span>
     <input type="text" id="ukloni_kocke" name="ukloni_kocke" />
     <span> kocaka iz reda broj </span>
     <select name="ukloni_red">
       <?php
         for ($x = 0; $x < $br_redova ; $x++) {
           $pom = 1+ $x;
           echo "<option value=".$x.">". $pom ."</option>";
         }
       ?>
     </select>

     <br><br>

     <input type="submit" class="button" name="novi_red" value="Dodaj novi red!"/>

     <br><br>

     <button type="submit">
         Napravi!
       </button>

     <input type="submit" class="button" name="kraj_igre" value="Kraj igre!"/>
   </form>

<?php } else {
  echo "<h3>Najveći broj kocaka: ". $_SESSION['max_kocaka']."</h3>";
  echo "<h3>Najmanji broj kocaka: ". $_SESSION['min_kocaka']."</h3>";
  session_unset();
	session_destroy();
} ?>
   </body>
 </html>

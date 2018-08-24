<?php
session_start();
ob_start();

$_naslovStranice = 'Početna stranica';
$_opisStranice = 'Dojave i tipovi sve za kladionicu';
$_kredit = 0;
include_once 'header.php'; 

if(!isset($_SESSION['memberUsername'])) { ?>
	<strong style="color: red;">Molimo Vas prijavite se ili registrirajte da bi mogli dalje koristiti aplikaciju!</strong><br>
	<a href="prijavaUser.php">Prijava</a><br>
	<a href="registracijaUser.php">Registracija</a><br><br>
	<p>Registrirajte se i pratite nas!</p>
	<a href="pitanjaiodgovori.php">Pitanja i odgovori</a><br>
	<strong>Za gledanje svih statistika ostalih novosti u nogemtu itd.. morate biti registrirani<br></strong>
	<hr style="border: 2px dotted green;">
<?php
} else { ?>
	<h4 style="color: blue;">Dobrodošli <?php echo $_SESSION['memberUsername']; ?></h4>
	<p>Pogledajte najnovije dojave koje su u tijeku <a href="dojave.php">ovdje</a></p>
<?php } ?>

<p>Pogledajte ponude:</p>
<a href="http://psk.hr/">Prva sportska kladionica PSK</a><br>
<a href="http://supersport.hr/">SuperSport</a> kladionica

<?php
include_once'footer.php';
?>
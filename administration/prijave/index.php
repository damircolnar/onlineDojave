<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
header("Location: ../login.php");
}

$_naslovStranice = 'Prijave problema';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT * FROM prijave GROUP BY id DESC";
$result = $db->query($query);

echo '<h1>Prijave korisnika</h1><br>';

while($problem = $result->fetch_assoc()) {
	echo '<strong>Korisnik koji je prijavio: </strong>' . $problem['korisnik'] . '<br>';
	echo '<strong>Email (kontakt): </strong>' . $problem['email'] . '<br>';
	echo '<strong>Opis problema: </strong><br>' . $problem['opis'] . '<br>';
	echo '<a class="btn btn-outline-success" href="odobriPrijavu.php" style="float: left;">Odobri</a>';
	echo '<a class="btn btn-outline-danger" href="odbijPrijavu.php" style="float: right;">Odbij</a><br><br>';
	echo '<hr style="background-color: red;">';
}

include_once '../footer.php';
?>
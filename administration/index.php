<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
header("Location: login.php");
}

$_naslovStranice = 'Administracija';
$_opisStranice = 'Custom CMS';
$_kredit = 0;
include_once 'header.php';

$query = "SELECT * FROM dojave GROUP BY id DESC";
$result = $db->query($query);

echo '<strong>Dobrodošli: </strong>' . $_SESSION['username'] . ' [Administrator]<br><br>';
echo '<h3>Objavljeni parovi:</h3><br>';

while($parovi = $result->fetch_assoc()) {
	echo '<strong>Objavio: </strong>' . $parovi['objavio'] . '<br>';
	echo '<strong>Parovi: </strong>' . $parovi['parovi'] . '<br>'; ?>
	<a class="btn btn-primary" href="uredi.php?id=<?php echo $parovi['id']; ?>">Uredi</a>
	<a class="btn btn-danger" href="obrisi.php?id=<?php echo $parovi['id']; ?>">Obriši</a><br><br>
<?php }

include_once 'footer.php'; ?>
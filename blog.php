<?php
session_start();
ob_start();

$_naslovStranice = 'Blog';
$_opisStranice = 'Doznajte sve novosti o nogometu.';
$_kredit = 0;

if(isset($_SESSION['uid'])) {
	$userId = $_SESSION['uid'];
}

include_once 'header.php';

$query = "SELECT * FROM blog GROUP BY idTeme DESC";
$result = $db->query($query);

$blogMode = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($blogMode);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->connect_error;
} else {
	$stmt->bind_param('i', $userId);
	$stmt->bind_result($id, $ime, $prezime, $username, $email, $password, $gradMjesto, $datumRodjenja, $activated, $blogMode1, $blocked);
	$result1 = $stmt->execute();
	if(!$result1) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

if($blogMode1 == 1) {
	echo '<a class="btn btn-primary" href="dodajClanak.php">Dodaj članak</a>';
}

if($result->num_rows > 0) {
	while($post = $result->fetch_assoc()) {
		echo '<h1>' . $post['naslovTeme'] . '</h1>';
		echo '<h6 style="color: blue;">' . $post['sadrzajTeme'] . '</h6>';
		echo '<strong>Objavio: ' . $post['ime'] . ' ' . $post['prezime'] . '</strong>'; 
		if($blogMode1 == 1) { ?>
			<br><a href="urediClanak.php?idClanka=<?php echo $post['idTeme']; ?>" class="btn btn-outline-primary" style="float: left;">Uredi</a>
			<a href="obrisiClanak.php?idClanka=<?php echo $post['idTeme']; ?>" class="btn btn-outline-danger" style="float: right;">Obriši</a><br><br>
		<?php } ?>
		<hr style="color: red; border: 1px solid red;">
	<?php }	
} else {
	echo '<br>Nema nađenih objava';
}
echo '<br><br>';

include_once 'footer.php';
?>
<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");
}

$_naslovStranice = 'Uređivanje članka';
$_opisStranice = '';
$_kredit = 0;

$clanakId = $_GET['idClanka'];
include_once 'header.php';

$korisnikQuery = "SELECT blogMode FROM users WHERE id = ?";
$stmt1 = $db->prepare($korisnikQuery);
if(!$stmt1) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt1->bind_param('i', $_SESSION['uid']);
	$stmt1->bind_result($blogMode);
	$result1 = $stmt1->execute();
	if(!$result1) {
		echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt1->connect_error;
	} else {
		$stmt1->fetch();
		$stmt1->close();
	}
}

$query = "SELECT * FROM blog WHERE idTeme = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $clanakId);
	$stmt->bind_result($idTeme, $ime, $prezime, $naslovTeme, $sadrzajTeme);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}
?>

<a class="btn btn-primary" href="blog.php">Natrag na Blog</a><br><br>

<form action="" method="POST" class="form-group">
	<?php
	if(!$blogMode == 1) {
		header("Location: blog.php");
	} else {
		if(!empty($_POST)) {
			$query = "UPDATE blog SET ime = ?, prezime = ?, naslovTeme = ?, sadrzajTeme = ? WHERE idTeme = ?";
			$stmt = $db->prepare($query);
			if(!$stmt) {
				echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
			} else {
				$stmt->bind_param('ssssi', $_SESSION['ime'], $_SESSION['prezime'], $_POST['naslovTeme'], $_POST['sadrzajTeme'], $clanakId);
				$result = $stmt->execute();
				header("Location: blog.php?successChanged");
				if(!$result) {
					echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->connect_error;
				}
				$stmt->close();
			}
		}	
	}
	?>
	<strong>Podaci ime i prezime će se automatski promjeniti po prijavljenoj sesiji!</strong><br><br>

	<label for="ime">Ime:</label>
	<p><?php echo $ime; ?></p>

	<label for="prezime">Prezime:</label>
	<p><?php echo $prezime; ?></p>

	<label for="naslovTeme">Nalov teme:</label>
	<input type="text" name="naslovTeme" id="naslovTeme" required value="<?php echo $naslovTeme; ?>" class="form-control">

	<label for="sadrzajTeme">Sadržaj teme:</label>
	<textarea name="sadrzajTeme" id="sadrzajTeme" cols="30" rows="8" class="form-control"><?php echo $sadrzajTeme; ?></textarea><br>

	<button type="submit" class="btn btn-success" style="float: left;">Uredi</button>
	<button type="reset" class="btn btn-danger" style="float: right;">Odustani</button><br><br>
</form>

<?php
include_once 'footer.php';
?>
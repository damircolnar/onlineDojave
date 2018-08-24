<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");

$_naslovStranice = 'Dodavanje novog članka';
$_opisStranice = '';
$_kredit = 0;
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

?>

<h1><?php echo $_naslovStranice; ?> <a class="btn btn-primary" href="blog.php">Natrag na Blog</a></h1>

<form action="" method="POST" class="form-group">
	<?php
	if(!$blogMode == 1) {
		header("Location: blog.php");
	} else {
		if(!empty($_POST)) {
			$query = "INSERT INTO blog(ime, prezime, naslovTeme, sadrzajTeme) VALUES (?, ?, ?, ?)";
			$stmt = $db->prepare($query);
			if(!$stmt) {
				echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
			} else {
				$stmt->bind_param('ssss', $_SESSION['ime'], $_SESSION['prezime'], $_POST['naslovTeme'], $_POST['sadrzajTeme']);
				$result = $stmt->execute();
				$clanakId = $stmt->insert_id;
				header("Location: blog.php");
				if(!$result) {
					echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
				}
				$stmt->close();
			}
		}
	}
	?>
	<label for="ime">Ime:</label>
	<p><?php echo $_SESSION['ime']; ?></p>

	<label for="prezime">Prezime:</label>
	<p><?php echo $_SESSION['prezime']; ?></p>

	<label for="naslovTeme">Naslov teme:</label>
	<input type="text" name="naslovTeme" id="naslovTeme" required class="form-control">

	<label for="sadrzajTeme">Sadržaj teme:</label>
	<textarea name="sadrzajTeme" id="sadrzajTeme" cols="30" rows="8" class="form-control" required></textarea><br>

	<button type="submit" class="btn btn-primary" style="float: left;">Objavi</button>
	<button type="reset" class="btn btn-danger" style="float: right;">Odustani</button>
</form><br><br>

<?php
include_once 'footer.php';
?>
<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");
}

$_naslovStranice = 'Moj Profil';
$_opisStranice = 'Pregled i izmjenjivanje profila';
$_kredit = 0;

$userId = $_SESSION['uid'];

include_once 'header.php';

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $userId);
	$stmt->bind_result($id, $ime, $prezime, $username, $email, $password, $gradMjesto, $datumRodjenja, $activated, $blogMode, $blocked);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

if(!empty($_POST)) {
	$query = "UPDATE users SET ime = ?, prezime = ?, username = ?, email = ?, password = ?, gradMjesto = ?, datumRodjenja = ? WHERE id = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt->bind_param('sssssssi', $_POST['ime'], $_POST['prezime'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['gradMjesto'], $_POST['datumRodjenja'], $userId);
		$result = $stmt->execute();
		header("Location: index.php?successChanged");
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
		}
		$stmt->close();
	}
}
?>

<form action="" method="POST" class="form-group">
	<label for="ime">Ime:</label>
	<input type="text" name="ime" id="ime" autofocus value="<?php echo $ime; ?>" class="form-control">

	<label for="prezime">Prezime:</label>
	<input type="text" name="prezime" id="prezime" value="<?php echo $prezime; ?>" class="form-control">

	<label for="username">Korisničko ime:</label>
	<input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control">

	<label for="email">Email:</label>
	<input type="email" name="email" id="email" value="<?php echo $email; ?>" class="form-control">

	<label for="password">Password:</label>
	<input type="password" name="password" id="password" value="<?php echo $password; ?>" class="form-control">

	<label for="gradMjesto">Grad ili mjesto stanovanja:</label>
	<input type="text" name="gradMjesto" id="gradMjesto" value="<?php echo $gradMjesto; ?>" class="form-control">

	<label for="datumRodjenja">Datum i godina rođenja:</label>
	<input type="date" name="datumRodjenja" id="datumRodjenja" value="<?php echo $datumRodjenja; ?>" class="form-control"><br>

	<button type="submit" style="float: left;" class="btn btn-primary">Promjeni podatke</button>
	<button type="reset" style="float: right;" class="btn btn-danger">Odustani</button><br><br>
</form>

<?php
include_once 'footer.php';
?>
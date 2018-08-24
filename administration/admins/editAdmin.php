<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$adminId = $_GET['adminId'];
$_naslovStranice = 'Edit admin ' . $adminId;
$_opisStranice = '';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT ime, prezime, username, email, password, gradMjesto, datumRodjenja FROM admins WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $adminId);
	$stmt->bind_result($ime, $prezime, $username, $email, $password, $gradMjesto, $datumRodjenja);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

echo '<h1>Edit Admin <a class="btn btn-primary" href="admins.php">Natrag na popis</a></h1>'; 

if(!empty($_POST)) {
	$query = "UPDATE admins SET ime = ?, prezime = ?, username = ?, email = ?, password = ?, gradMjesto = ?, datumRodjenja = ? WHERE id = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->error;
	} else {
		$stmt->bind_param('sssssssi', $_POST['ime'], $_POST['prezime'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['gradMjesto'], $_POST['datumRodjenja'], $adminId);
		$result = $stmt->execute();
		header("Location: admins.php");
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->error;
		}
		$stmt->close();
	}
}
?>

<form action="" method="POST" class="form-group">
	<label for="ime">Ime:</label>
	<input type="text" name="ime" id="ime" autofocus class="form-control" value="<?php echo $ime; ?>">

	<label for="prezime">Prezime:</label>
	<input type="text" name="prezime" id="prezime" class="form-control" value="<?php echo $prezime; ?>">

	<label for="username">Username;</label>
	<input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">

	<label for="email">Email:</label>
	<input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">

	<label for="password">Password:</label>
	<input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>">

	<label for="gradMjesto">Grad ili Mjesto:</label>
	<input type="text" name="gradMjesto" id="gradMjesto" class="form-control" value="<?php echo $gradMjesto; ?>">

	<label for="datumRodjenja">Datum i godina rođenja:</label>
	<input type="date" name="datumRodjenja" id="datumRodjenja" class="form-control" value="<?php echo $datumRodjenja; ?>"><br>

	<button type="submit" class="btn btn-primary" style="float: left">Promjeni</button>
	<button type="reset" class="btn btn-danger" style="float: right">Odustani</button>
</form>

<?php
include_once '../footer.php';
?>
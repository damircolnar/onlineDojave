<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$_naslovStranice = 'Add new admin';
$_opisStranice = '';
$_kredit = 0;
include_once '../header.php';

echo '<h1>Add new administrator</h1>'; 

if(!empty($_POST)) {
	$query = "INSERT INTO admins(ime, prezime, username, email, password, gradMjesto, datumRodjenja) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->connect_error;
	} else {
		$stmt->bind_param('sssssss', $_POST['ime'], $_POST['prezime'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['gradMjesto'], $_POST['datumRodjenja']);
		$result = $stmt->execute();
		$adminId = $stmt->insert_id;
		header("Location: admins.php");
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->error;
		}
		$stmt->close();
	}
}

?>

<form action="" method="POST" class="form-group">
	<label for="ime">Vaše ime:</label>
	<input type="text" name="ime" id="ime" autofocus class="form-control">

	<label for="prezime">Vaše prezime:</label>
	<input type="text" name="prezime" id="prezime" class="form-control">

	<label for="username">Username:</label>
	<input type="text" name="username" id="username" class="form-control">

	<label for="email">Email:</label>
	<input type="email" name="email" id="email" class="form-control">

	<label for="password">Password:</label>
	<input type="password" name="password" id="password" class="form-control">

	<label for="gradMjesto">Grad ili Mjesto gdje živite:</label>
	<input type="text" name="gradMjesto" id="gradMjesto" class="form-control">

	<label for="datumRodjenja">Datum i godina rođenja:</label>
	<input type="date" name="datumRodjenja" id="datumRodjenja" class="form-control"><br>

	<button type="submit" class="btn btn-primary">Add</button>
	<button type="reset" style="float: right;" class="btn btn-danger">Odustani</button>
</form>

<?php
include_once '../footer.php';
?>
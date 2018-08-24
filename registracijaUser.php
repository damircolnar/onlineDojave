<?php
$_naslovStranice = 'Registracija u sustav';
$_opisStranice = '';
$_kredit = 5;
include_once 'header.php';

if(!empty($_POST)) {
	$query = "INSERT INTO users(ime, prezime, username, email, password, gradMjesto, datumRodjenja) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->connect_error;
	} else {
		$stmt->bind_param('sssssss', $_POST['ime'], $_POST['prezime'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['gradMjesto'], $_POST['datumRodjenja']);
		$result = $stmt->execute();
		$userId = $stmt->insert_id;
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->error;
		}
		$stmt->close();
	}
	$insertCredits = "INSERT INTO credits(userId, credit, username) VALUES (?, ?, ?)";
	$stmt1 = $db->prepare($insertCredits);
	if(!$stmt1) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt1->bind_param('iis', $userId, $_kredit, $_POST['username']);
		$result1 = $stmt1->execute();
		$creditId = $stmt1->insert_id;
		header("Location: index.php");
		if(!$result1) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt1->connect_error;
		}
		$stmt1->close();
	}
}

?>

<form action="" method="POST" class="form-group">
	<label for="ime">Vaše ime:</label>
	<input type="text" name="ime" id="ime" required autofocus class="form-control">

	<label for="prezime">Vaše prezime:</label>
	<input type="text" name="prezime" id="prezime" required class="form-control">

	<label for="username">Username:</label>
	<input type="text" name="username" id="username" required class="form-control">

	<label for="email">Email:</label>
	<input type="email" name="email" id="email" required class="form-control">

	<label for="password">Password:</label>
	<input type="password" name="password" id="password" required class="form-control">

	<label for="gradMjesto">Grad ili Mjesto gdje živite:</label>
	<input type="text" name="gradMjesto" id="gradMjesto" required class="form-control">

	<label for="datumRodjenja">Datum i godina rođenja:</label>
	<input type="date" name="datumRodjenja" id="datumRodjenja" required class="form-control"><br>

	<button type="submit" class="btn btn-primary">Add</button>
	<button type="reset" style="float: right;" class="btn btn-danger">Odustani</button>
</form>

<?php
include_once 'footer.php';
?>
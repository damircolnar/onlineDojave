<?php
session_start();
ob_start();
$_SESSION['lastTime'] = time();
if(isset($_SESSION['username'])) {
	header("Location: index.php");
}
$_naslovStranice = "Administration Login";
$_kredit = 0;
include_once 'header.php';

$query = "SELECT * FROM admins";
$result = $db->query($query);

echo '<h1>Administrator login</h1>';

if(!empty($_POST)) {
	while($korisnik = $result->fetch_assoc()) {
		if($_POST['username'] == $korisnik['username'] && $_POST['password'] == $korisnik['password']) {
			$_SESSION['username'] = $_POST['username'];
			header("Location: index.php");
		} else {
			echo '<strong>Krivo ste unijeli korisničko ime ili lozinku!</strong>';
		}
	}
}
?>

<form action="" method="POST" class="form-group">
	<label for="username">Username:</label>
	<input type="text" name="username" id="username" autofocus required class="form-control">

	<label for="password">Password:</label>
	<input type="password" name="password" id="password" required class="form-control"><br>

	<button type="submit" class="btn btn-primary">Login</button>
	<button type="reset" style="float: right;" class="btn btn-danger">Odustani</button>
</form>

<a href="">Zahtjev za administraciju</a><br>
<a href="../index.php">Natrag na početnu stranicu</a>

<?php
include_once 'footer.php';
?>
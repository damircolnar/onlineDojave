<?php
session_start();
ob_start();
if(isset($_SESSION['memberUsername'])) {
	header("Location: dojave.php");
}

$_naslovStranice = 'Prijava korisnika';
$_kredit = 0;
include_once 'header.php'; ?>

<h1>Prijava korisnika</h1>
	<?php
	$query = "SELECT * FROM users";
	$result = $db->query($query);

	if(!empty($_POST)) {
		while($korisnik = $result->fetch_assoc()) {
			if($_POST['username'] == $korisnik['username'] && $_POST['password'] == $korisnik['password']) {
				$_SESSION['memberUsername'] = $_POST['username'];
				$_SESSION['uid'] = $korisnik['id'];
				$_SESSION['blogMode'] = $korisnik['blogMode'];
				$_SESSION['ime'] = $korisnik['ime'];
				$_SESSION['prezime'] = $korisnik['prezime'];
				$_SESSION['blocked'] = $korisnik['blocked'];
				header("Location: dojave.php");
			}
		}
	}
	?>
<form action="" method="POST" class="form-group">
	<label for="username">Korisničko ime:</label>
	<input type="text" name="username" id="username" autofocus required class="form-control">

	<label for="password">Lozinka:</label>
	<input type="password" name="password" id="password" required class="form-control"><br>

	<button type="submit" class="btn btn-primary" style="float: left;">Prijava</button>
	<button type="reset" class="btn btn-danger" style="float: right;">Odustani</button><br><br>
</form>

<a href="zaboravljenaLozinka.php">Zaboravili ste lozinku?</a><br>

<?php
include_once 'footer.php';
?>
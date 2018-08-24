<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
header("Location: login.php");
}

$_naslovStranice = 'SQL Query';
$_opisStranice = 'Izvršavanje SQL upita';
$_kredit = 0;
include_once 'header.php';
?>

<h1><?php echo $_naslovStranice; ?></h1>
<p><?php echo $_opisStranice; ?></p>

<strong style="color: red;">Tablice u bazi i stupci:</strong>
<p>admins ==> id, ime, prezime, username, email, password, gradMjesto, activated, datumRodjenja<br>
blog ==> idTeme, ime, prezime, naslovTeme, sadrzajTeme<br>
dojave ==> id, objavio, parovi, datumObjavljivanja<br>
prijave ==> id, korisnik, email, opis<br>
users ==> id, ime, prezime, username, email, password, gradMjesto, datumRodjenja, activated, blogMode</p>

<form action="" method="POST" class="form-group">
	<?php
	if(!empty($_POST)) {
		$query = $_POST['query'];
		$result = $db->query($query);
	}
	?>
	<label for="query">Query:</label>
	<textarea name="query" id="query" autofocus required class="form-control"></textarea><br>
	<button type="submit" class="btn btn-primary" style="float: left;">Izvrši upit</button>
	<button type="reset" class="btn btn-danger" style="float: right;">Odustani</button>
</form>

<?php
include_once 'footer.php';
?>
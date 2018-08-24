<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$_naslovStranice = 'Uredi';
$_opisStranice = '';
$_kredit = 0;
$userId = $_GET['id'];
include_once '../header.php'; ?>

<h1><?php echo $_naslovStranice; ?></h1>

<form action="" method="POST" class="form-group">
	<?php
	if(!empty($_POST)) {
		$query = 'UPDATE credits SET credit = credit ' . $_POST['operacija'] . ' ' . $_POST['dodatiOduzet'] . ' WHERE userId = ?';
		$stmt = $db->prepare($query);
		if(!$stmt) {
			echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->error;
		} else {
			$stmt->bind_param('i', $userId);
			$result = $stmt->execute();
			header("Location: index.php");
			if(!$result) {
				echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->connect_error;
			}
			$stmt->close();
		}
	}
	?>
	<label for="operacija">Operacija</label>
	<input type="text" name="operacija" id="operacija" autofocus required placeholder="Upisati samo + ili -" class="form-control">

	<label for="dodatiOduzet">Dodati ili oduzeti kredita:</label>
	<input type="number" name="dodatiOduzet" id="dodatiOduzet" required placeholder="Ovdje upišite koliko želite dodati ili oduzeti kredita" class="form-control"><br>

	<button type="submit" class="btn btn-primary" style="float: left;">Uredi</button>
	<button type="submit" class="btn btn-danger" style="float: right;">Odustani</button><br><br>
</form>

<?php
include_once '../footer.php';
?>
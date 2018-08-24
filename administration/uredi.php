<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
header("Location: login.php");
}

$idPara = $_GET['id'];
$_naslovStranice = 'Edit | id: ' . $idPara;
$_kredit = 0;
include_once 'header.php'; 

if(!empty($_POST)) {
	$query = "UPDATE dojave SET objavio = ?, parovi = ? WHERE id = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->connect_error;
	} else {
		$stmt->bind_param('ssi', $_POST['objavio'], $_POST['parovi'], $idPara);
		$result = $stmt->execute();
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametra ' . $stmt->error;
		}
		$stmt->close();
	}
}

$query = "SELECT objavio, parovi FROM dojave WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->connect_error;
} else {
	$stmt->bind_param('i', $idPara);
	$stmt->bind_result($objavio, $parovi);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja parametra ' . $stmt->error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

?>

<h1>Edit <a class="btn btn-primary" href="index.php">Natrag</a></h1>

<form action="" method="POST" class="form-group">
	<label for="objavio">Objavio:</label>
	<input type="text" id="objavio" name="objavio" class="form-control" value="<?php echo $objavio; ?>" autofocus>

	<label for="parovi">Parovi:</label>
	<textarea name="parovi" id="parovi" cols="30" class="form-control"><?php echo $parovi; ?></textarea>

	<button type="submit" class="btn btn-primary" style="float: left;">Primjeni</button>
	<button type="reset" class="btn btn-danger" style="float: right;">Odustani</button>
</form>

<?php
include_once 'footer.php';
?>

<div class="createdBy" style="background-color: silver;  color: red; position: fixed; height: 100%; width: 100%; margin: 150px 100px 100px 0px;">
	<strong>Izradio: Damir Colnar</strong><br>
	<a href="../index.php">Početna stranica</a>
</div>
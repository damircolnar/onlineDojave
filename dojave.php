<?php
session_start();
ob_start();

$_naslovStranice = 'Dojave';
//$_kredit = 0;
include_once 'header.php';


if(!empty($_POST)) {
	$query = "INSERT INTO dojave(objavio, parovi) VALUES (?, ?)";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripreme parametara ' . $db->error;
	} else {
		$stmt->bind_param('ss', $_SESSION['memberUsername'], $_POST['parovi']);
		$result = $stmt->execute();
		$parId = $stmt->insert_id;
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametra ' . $stmt->error;
		}
		$stmt->close();
	}
	$insertCredits = "UPDATE credits SET credit = credit + 3 WHERE userId = ?";
	$stmt1 = $db->prepare($insertCredits);
	if(!$stmt1) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt1->bind_param('i', $_SESSION['uid']);
		$result1 = $stmt1->execute();
		header("Location: dojave.php");
		if(!$result1) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt1->connect_error;
		}
		$stmt1->close();
	}
}

$query = "SELECT * FROM dojave GROUP BY id DESC";
$result = $db->query($query);
?>

<?php
if(isset($_SESSION['memberUsername'])) { ?>
	<form action="" method="POST" class="form-group">
		<label for="objavio">Objavio:</label>
		<p style="color: red;"><?php echo $_SESSION['memberUsername']; ?></p>

		<label for="parovi">Vaši parovi ovdje:</label>
		<textarea name="parovi" id="parovi" cols="30" class="form-control"></textarea><br>

		<button type="submit" style="float: left;" class="btn btn-primary">Objavi dojavu</button>
		<button type="submit" style="float: right;" class="btn btn-danger">Odustani</button>
	</form><br>
	<center><strong style="color: blue; font-size: 20px; background-color: yellow;">Parove koje objavljivate ne možete više uređivati ni brisati, samo administratori!<br><a href="#prijava-problema" style="color: red;">Ovdje prijavite!</a></strong></center><br>
<?php } ?>

<h3>Objavljeni parovi:</h3>
<strong style="color: red;">Svaka dojava je 2 kredita i ne možete ju vidijeti ukoliko nemate dovoljno kredita!</strong><br>
<?php
	if(!isset($_SESSION['memberUsername'])) {
		echo '<strong style="color: red;">Morate biti prijavljeni da bi vidijeli parove!</strong><br>';
		echo '<a href="prijavaUser.php">Prijava</a><br>';
		echo '<a href="registracijaUser.php">Registracija</a>';
	} else {
		while($parovi = $result->fetch_assoc()) {
			$datumObjavljivanja = $parovi['datumObjavljivanja'];
			$resultDatum = $datumObjavljivanja[0] . $datumObjavljivanja[1] . $datumObjavljivanja[2] . $datumObjavljivanja[3] . $datumObjavljivanja[4] . $datumObjavljivanja[5] . $datumObjavljivanja[6] . $datumObjavljivanja[7] . $datumObjavljivanja[8] . $datumObjavljivanja[9];
			if($_kredit >= $parovi['dojavaCredit']) {
				if($_SESSION['memberUsername'] == $parovi['objavio']) {
					echo '<br><strong>Objavio: </strong>' . $parovi['objavio'] . '<br>';
					echo '<strong>Parovi: </strong>' . $parovi['parovi'] . '<br>';
					echo '<strong>Datum objavljivanja: </strong>' . $resultDatum .  '<br><br>';
				} else {
					echo '<strong>Objavio: </strong>' . $parovi['objavio'] . '<br>'; ?>
					<a href="pogledajDojavu.php?dojavaId=<?php echo $parovi['id']; ?>&credit=<?php echo $parovi['dojavaCredit']; ?>" class="btn btn-primary btn-sm">Pogledaj dojavu</a><br>
					<strong>Datum objavljivanja: </strong><?php echo $resultDatum; ?>
					<br><br>
				<?php }
			}
		}
	}
?>
<br>

<?php
if(isset($_SESSION['memberUsername'])) { ?>
<div id="prijava-problema" style="background-color: silver;">
<form action="" method="POST" class="form-group" name="prijava-problema-form">
	<center><h3>Prijavite problem..</h3></center>

	<label for="email">Email adresa:</label>
	<input type="email" style="color: red; font-size: 16px;" id="email" name="email" required class="form-control">

	<label for="opisProblema">Opis problema i sl.:</label>
	<textarea style="color: blue; font-size: 16px;" class="form-control" rows="5" name="opisProblema" id="opisProblema" required></textarea>

	<button type="submit" name="posalji" class="btn btn-outline-success">Pošalji</button>
	<button type="reset" style="float: right;" class="btn btn-outline-danger">Odustani</button>
</form>
</div>
<?php }

if(isset($_POST['posalji'])) {
	$query = "INSERT INTO prijave(korisnik, email, opis) VALUES (?, ?, ?)";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt->bind_param('sss', $_SESSION['memberUsername'], $_POST['email'], $_POST['opisProblema']);
		$result = $stmt->execute();
		$problemId = $stmt->insert_id;
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
		}
		$stmt->close();
	}
}
?>

<center><a href="#">Natrag na Vrh</a></center><br><br>

<?php
include_once 'footer.php';
?>
<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");
}

$_naslovStranice = 'Pogledaj dojavu';
$dojavaId = $_GET['dojavaId'];
$dojavaCredit = $_GET['credit'];
include_once 'header.php'; 
?>

<h1>Pogledaj dojavu</h1>
<?php
if($_kredit < $dojavaCredit) {
	header("Location: dojave.php");
} else if($_kredit >= $dojavaCredit) {
	$query = "UPDATE credits SET credit = credit - 2 WHERE userId = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt->bind_param('i', $_SESSION['uid']);
		$result = $stmt->execute();
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
		}
		$stmt->close();
	}
	$pogledajDojavu = "SELECT * FROM dojave WHERE id = ?";
	$stmt1 = $db->prepare($pogledajDojavu);
	if(!$stmt1) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt1->bind_param('i', $dojavaId);
		$stmt1->bind_result($id, $objavio, $parovi, $datumObjavljivanja, $dojavaCredit);
		$result1 = $stmt1->execute();
		if(!$result1) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt1->connect_error;
		} else {
			$stmt1->fetch();
			$stmt1->close();
		}
	}
	// Linija koda za plaćanje dojave..
	$query = 'SELECT users.id, users.username, credits.credit, credits.creditId FROM users LEFT JOIN credits ON users.id = credits.userId WHERE username = ' . $objavio;
	$result = $db->query($query);

	$platitiDojavitelju = "UPDATE credits SET credit = credit + 2 WHERE username = ?";
	$stmtPlati = $db->prepare($platitiDojavitelju);
	if(!$stmtPlati) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmtPlati->bind_param('s', $objavio);
		$resultPlati = $stmtPlati->execute();
		if(!$resultPlati) {
			echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmtPlati->connect_error;
		}
		$stmtPlati->close();
	}
}
?>

<strong>Objavio: <?php echo $objavio; ?></strong>
<p><?php echo $parovi; ?></p>

<?php
include_once 'footer.php';
?>
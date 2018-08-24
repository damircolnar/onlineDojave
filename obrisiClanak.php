<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");

$_naslovStranice = 'Brisanje članka';
$_opisStranice = '';
$_kredit = 0;

$clanakId = $_GET['idClanka'];
include_once 'header.php';

$korisnikQuery = "SELECT blogMode FROM users WHERE id = ?";
$stmt1 = $db->prepare($korisnikQuery);
if(!$stmt1) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt1->bind_param('i', $_SESSION['uid']);
	$stmt1->bind_result($blogMode);
	$result1 = $stmt1->execute();
	if(!$result1) {
		echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt1->connect_error;
	} else {
		$stmt1->fetch();
		$stmt1->close();
	}
}

if(!$blogMode == 1) {
	header("Location: blog.php");
} else {
	$query = "DELETE FROM blog WHERE idTeme = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja parametara ' . $db->error;
	} else {
		$stmt->bind_param('i', $clanakId);
		$result = $stmt->execute();
		header("Location: blog.php");
		if(!$result) {
			echo 'Došlo je do greške prilikom izvršavanja parametara ' . $stmt->connect_error;
		}
		$stmt->close();
	}
	$db->close();
}

include_once 'footer.php';
?>
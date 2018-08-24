<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
header("Location: login.php");
}

$idPara = $_GET['id'];
$_naslovStranice = 'Delete | id: ' . $idPara;
$_kredit = 0;
include_once '../header.php';

$query = "DELETE FROM dojave WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja parametra ' . $db->connect_error;
} else {
	$stmt->bind_param('i', $idPara);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja parametra ' . $stmt->error;
	}
	$stmt->close();
}
$db->close();

include_once '../footer.php';
?>
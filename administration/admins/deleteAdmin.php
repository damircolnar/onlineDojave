<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$adminId = $_GET['adminId'];
$_naslovStranice = 'Delete admin ' . $adminId;
$_opisStranice = '';
$_kredit = 0;
includE_once '../header.php';

$query = "DELETE FROM admins WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $adminId);
	$result = $stmt->execute();
	header("Location: admins.php");
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->error;
	}
	$stmt->close();
}
$db->close();

include_once '../footer.php';
?>
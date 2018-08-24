<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$userId = $_GET['userId'];
$_naslovStranice = 'Delete user ' . $userId;
$_opisStranice = '';
$_kredit = 0;
includE_once '../header.php';

$query = "DELETE FROM users WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $userId);
	$result = $stmt->execute();
	header("Location: index.php");
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->error;
	}
	$stmt->close();
}
$db->close();

include_once '../footer.php';
?>
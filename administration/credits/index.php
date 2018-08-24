<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$_naslovStranice = 'Krediti';
$_opisStranice = '';
$_kredit = 0;
include_once '../header.php'; 

$query = "SELECT users.id, users.username, credits.credit, credits.creditId FROM users LEFT JOIN credits ON users.id = credits.userId";
$result = $db->query($query);
?>

<h1><?php echo $_naslovStranice; ?></h1>

<table border="1">
	<thead>
		<tr>
			<th>Credit ID:</th>
			<th>User ID:</th>
			<th>Username:</th>
			<th>Credits:</th>
			<th>OP:</th>
		</tr>
	</thead>

	<tbody>
		<?php
		while($korisnikKredit = $result->fetch_assoc()) { ?>
			<tr>
				<td><?php echo $korisnikKredit['creditId']; ?></td>
				<td><?php echo $korisnikKredit['id']; ?></td>
				<td><?php echo $korisnikKredit['username']; ?></td>
				<td><?php echo $korisnikKredit['credit']; ?></td>
				<td><a class="btn btn-primary btn-sm" href="uredi.php?id=<?php echo $korisnikKredit['id']; ?>">Uredi</a>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php
$ukupnoKredita = "SELECT SUM(credit) FROM credits";
$stmt = $db->prepare($ukupnoKredita);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_result($creditsTotal);
	$result1 = $stmt->execute();
	if(!$result1) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

echo '<strong>Ukupno kredita: ' . $creditsTotal . '</strong>';
include_once '../footer.php';
?>
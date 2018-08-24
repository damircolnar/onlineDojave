<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$_naslovStranice = 'Users';
$_opisStranice = 'Users administration';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT * FROM users";
$result = $db->query($query);

echo '<h1>Users Administration <a class="btn btn-primary" href="newuser.php">Dodaj korisnika</a></h1>'; ?>

<table border="1">
	<thead>
		<tr>
			<th>ID:</th>
			<th>Username:</th>
			<th>Email:</th>
			<th>Activated:</th>
		</tr>
	</thead>
	<tbody>
		
<?php
while($user = $result->fetch_assoc()) { ?>
	<tr>
		<td><?php echo $user['id']; ?></td>
		<td><a href="details.php?id=<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></td>
		<td><?php echo $user['email']; ?></td>
		<?php
		if($user['activated'] == 0) { ?>
			<td><?php echo 'Račun nije aktiviran ' . $user['activated']; ?></td>
		<?php } else if ($user['activated'] == 1) { ?>
			<td><?php echo 'Račun je aktiviran ' . $user['activated']; ?></td>
		<?php } ?>
	</tr>
<?php } ?>
	</tbody>
</table>

<?php
include_once '../footer.php';
?>
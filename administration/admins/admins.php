<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	header("Location: ../login.php");
}

$_naslovStranice = 'Admins';
$_opisStranice = 'Admins administration';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT * FROM admins";
$result = $db->query($query);

echo '<h1>Admins Administration <a class="btn btn-primary" href="newadmin.php">Dodaj administratora</a></h1>'; ?>

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
while($admin = $result->fetch_assoc()) { ?>
	<tr>
		<td><?php echo $admin['id']; ?></td>
		<td><a href="details.php?id=<?php echo $admin['id']; ?>"><?php echo $admin['username']; ?></a></td>
		<td><?php echo $admin['email']; ?></td>
		<?php
		if($admin['activated'] == 0) { ?>
			<td><?php echo 'Račun nije aktiviran ' . $admin['activated']; ?></td>
		<?php } else if ($admin['activated'] == 1) { ?>
			<td><?php echo 'Račun je aktiviran ' . $admin['activated']; ?></td>
		<?php } ?>
	</tr>
<?php } ?>
	</tbody>
</table>

<?php
include_once '../footer.php';
?>
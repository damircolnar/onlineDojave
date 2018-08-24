<?php
session_start();
ob_start();
if(!isset($_SESSION['memberUsername'])) {
	header("Location: prijavaUser.php");
}

$_naslovStranice = 'Popis kladioničara';
$_opisStranice = 'Pogledajte popis svih kladioničara koji su registrirani, i koji objavljuju ili mogu objavljivati dojave.';
$_kredit = 0;
include_once 'header.php';

$query = "SELECT * FROM users";
$result = $db->query($query);
?>

<table class="table">
	<thead>
		<tr>
			<th style="background-color: #333; color: white;">Username:</th>
			<th style="background-color: #333; color: white;">Email:</th>
		</tr>
	</thead>
	<tbody>	
<?php
while($kladionicar = $result->fetch_assoc()) { ?>
	<tr>
		<td><?php echo $kladionicar['username']; ?></td>
		<td><?php echo $kladionicar['email']; ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>

<?php
include_once 'footer.php';
?>
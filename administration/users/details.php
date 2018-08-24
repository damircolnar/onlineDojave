<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	/*echo '<script language="javascript">';
	echo 'document.location.replace("../login.php");';
	echo '</script>';*/
	header("Location: ../login.php");
}

$userId = $_GET['id'];
$_naslovStranice = 'Details of user ' . $userId;
$_opisStranice = '';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->connect_error;
} else {
	$stmt->bind_param('i', $userId);
	$stmt->bind_result($id, $ime, $prezime, $username, $email, $password, $gradMjesto, $datumRodjenja, $activated, $blogMode, $blocked);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->connect_error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

$dat = explode('-', $datumRodjenja);

echo '<h1>Details of user</h1>'; ?>

<dl class="row">
		<dt class="col-sm-3">ID:</dt>
		<dd class="col-sm-9"><?php echo $id; ?></dd>
		<dt class="col-sm-3">Ime:</dt>
		<dd class="col-sm-9"><?php echo $ime; ?></dd>
		<dt class="col-sm-3">Prezime:</dt>
		<dd class="col-sm-9"><?php echo $prezime; ?></dd>
		<dt class="col-sm-3">Username:</dt>
		<dd class="col-sm-9"><?php echo $username; ?></dd>
		<dt class="col-sm-3">Email:</dt>
		<dd class="col-sm-9"><?php echo $email; ?></dd>		
		<dt class="col-sm-3">Grad ili Mjesto:</dt>
		<dd class="col-sm-9"><?php echo $gradMjesto; ?></dd>
		<dt class="col-sm-3">Datum i godina rođenja::</dt>
		<dd class="col-sm-9"><?php echo $dat[2] . '.' .  $dat[1] . '.' . $dat[0]; ?></dd>
		<dt class="col-sm-3">Activated:</dt>
		<dd class="col-sm-9">
			<?php if($activated == 0) {
				echo '<p style="color: red;">Račun nije aktiviran ' . $activated . '</p>';
			} else if($activated == 1) {
				echo '<p style="color: blue;">Račun je aktiviran ' . $activated . '</p>';
			} ?>
		</dd>
</dl>
<a class="btn btn-primary" href="editUser.php?userId=<?php echo $id; ?>">Uredi</a>
<a class="btn btn-danger" href="deleteUser.php?userId=<?php echo $id; ?>">Izbriši korisnika</a>
<?php
if($blocked == 0) { ?>
	<a class="btn btn-secondary" href="blokirajClana.php?id=<?php echo $id; ?>">Blokiraj</a>
<?php } else if($blocked == 1) { ?>
	<a class="btn btn-secondary" href="unblockMember.php?userId=<?php echo $id; ?>">Odblokiraj</a>
<?php }

include_once '../footer.php';
?>
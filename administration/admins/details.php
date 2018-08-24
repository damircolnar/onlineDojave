<?php
session_start();
ob_start();
if(!isset($_SESSION['username'])) {
	/*echo '<script language="javascript">';
	echo 'document.location.replace("../login.php");';
	echo '</script>';*/
	header("Location: ../login.php");
}

$adminId = $_GET['id'];
$_naslovStranice = 'Details of user ' . $adminId;
$_opisStranice = '';
$_kredit = 0;
include_once '../header.php';

$query = "SELECT * FROM admins WHERE id = ?";
$stmt = $db->prepare($query);
if(!$stmt) {
	echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
} else {
	$stmt->bind_param('i', $adminId);
	$stmt->bind_result($id, $ime, $prezime, $username, $email, $password, $gradMjesto, $datumRodjenja, $activated);
	$result = $stmt->execute();
	if(!$result) {
		echo 'Došlo je do greške prilikom izvršavanja upita ' . $stmt->error;
	} else {
		$stmt->fetch();
		$stmt->close();
	}
}

$dat = explode('-', $datumRodjenja);

echo '<h1>Details of admin</h1>'; ?>

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
<a class="btn btn-primary" href="editAdmin.php?adminId=<?php echo $id; ?>">Uredi</a>
<a class="btn btn-danger" href="deleteAdmin.php?adminId=<?php echo $id; ?>">Izbriši admina</a>
<button class="btn btn-secondary" disabled>Blokiraj</button>

<?php
include_once '../footer.php';
?>
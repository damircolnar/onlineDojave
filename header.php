<!DOCTYPE html>
<head>
	<?php
	include_once 'db.php';
	if(empty($_opisStranice) && empty($_kredit)) {
		$_opisStranice = '';
		$_kredit = '';
	}

	$query = "SELECT * FROM users";
	$result = $db->query($query);

	if(isset($_SESSION['memberUsername'])) {
	$query = "SELECT users.id, credits.credit FROM users LEFT JOIN credits ON users.id = credits.userId WHERE id = ?";
	$stmt = $db->prepare($query);
	if(!$stmt) {
		echo 'Došlo je do greške prilikom pripremanja upita ' . $db->error;
	} else {
		$stmt->bind_param('i', $_SESSION['uid']);
		$stmt->bind_result($userId, $credit);
		$result = $stmt->execute();
		if(!$result) {
			echo 'Došlo je do greške prilikom ozvršavanja upita ' . $stmt->connect_error;
		} else {
			$stmt->fetch();
			$stmt->close();
		}
	}
}
	if(isset($_SESSION['memberUsername'])) {
		$_kredit = $credit;
	}

	if(isset($_SESSION['blocked'])) {
		if($_SESSION['blocked'] == 1) {
			header("Location: blocked.php");
		}
	}
	?>
	<title><?php echo $_naslovStranice; ?> | Online dojave</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="desicription" content="Online dojave za kladionicu, i sve ostalo u vezi klađenja">
	<meta name="keywords" content="dojave, kladionica, klađenje, tipovi">
	<style>
	.vl {
		border-left: 6px solid lime;
		height: 100%;
	}
	</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">Online dojave</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Početna stranica<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="dojave.php">Dojave</a>
      </li>
      <li class="nav-item">
      	<a class="nav-link" href="blog.php">Blog</a>
      </li>
      <li>
      	<div class="vl"></div>
      </li>
      <?php
      if(isset($_SESSION['memberUsername'])) { ?>
		<li class="nav-item">
			<a href="logout.php" class="nav-link">Logout</a>
		</li>
     <?php } ?>
    </ul>
  </div>
</nav>

<br>
<br>

<div class="jumbotron jumbotron-fluid">
	<div class="container">
	<h1 class="display-4"><?php echo $_naslovStranice; ?></h1>
	<p class="lead"><?php echo $_opisStranice; ?></p>
	<strong>Trenutno stanje kredita: <?php echo $_kredit . '<br>'; ?></strong>
	<?php
	if(isset($_SESSION['memberUsername'])) { 
		?>
		<div style="font-size: 20px;">
			<a href="pitanjaiodgovori.php">Pitanja i odgovori</a> | 
			<br>
			<a href="profil.php?userId=<?php echo $_SESSION['uid']; ?>">Moj Profil</a> | 
			<a href="statistika.php">Statistika</a> | 
			<a href="kladionicari.php">Popis kladioničara</a> | 
			<a href="logout.php">Logout</a> | 
		</div>
	<?php } ?>
	</div>
</div>

<div class="container">
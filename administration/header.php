<!DOCTYPE html>
<head>
	<?php
	include_once '../db.php';
	if(empty($_opisStranice)) {
		$_opisStranice = '';
	}

	if(time() - $_SESSION['lastTime'] > 300) {
	session_destroy();
	header("Location: login.php");
	}
	?>
	<title><?php echo $_naslovStranice; ?> | Online dojave</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<style>
	.vl {
		border-left: 6px solid lime;
		height: 100%;
	}
	</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="/onlineDojave/administration/index.php">Online dojave</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="/onlineDojave/administration/index.php">Admin dojave<span class="sr-only">(current)</span></a>
      </li>
      <li>
      	<div class="vl"></div>
      	<?php
      	if(isset($_SESSION['username'])) { ?>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/logout.php">Logout</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/admins/admins.php">Admins</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/users/index.php">Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/prijave/index.php">Prijave</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/sqlQuery.php">SQL Query</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/onlineDojave/administration/credits/index.php">Krediti</a>
		</li>
      	<?php } ?>
    </ul>
  </div>
</nav>

<br>
<br>
<br>

<div class="container">
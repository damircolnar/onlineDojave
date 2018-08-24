<?php
session_start();
ob_start();

$_naslovStranice = 'Obriši dojavu';
$_kredit = 0;

$parId = $_GET['id'];

include_once 'header.php';

echo '<strong style="color: red;">U izradi | Under Construction!</strong>';

include_once 'footer.php';
?>
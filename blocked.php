<?php
session_start();
ob_start();

$_naslovStranice = 'Blocked';
$_opisStranice = '';
$_kredit = 0;
include_once 'header.php';

echo '<strong>Administrator aplikacije vam je onemogućio pristup!</strong>';

session_destroy();

include_once 'footer.php';
?>
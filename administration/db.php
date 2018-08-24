<?php

$db = @new mysqli("localhost", "root", "", "kladionica");

if($db->connect_error) {
	echo 'Došlo je do greške prilikom povezivanja na bazu ' . $db->connect_error;
	die();
}

if(!$db->set_charset('utf8mb4')) {
	echo 'Došlo je do greške prilikom postavljanja charset-a ' . $db->error;
	die();
}
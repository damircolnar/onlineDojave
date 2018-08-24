<?php
session_start();
ob_start();

$_naslovStranice = 'Statistika kladioničara';
$_opisStranice = 'Ovdje možete doznati informacije tko je koliko parova pogodio i ostalo.';
$_kredit = 0;
include_once 'header.php';
?>

<p>Trenutno je statistika još u izradi.</p>
<table class="table">
	<thead class="bg-info">
		<tr>
			<th>Kladioničar:</th>
			<th>Pogođeno:</th>
			<th>Krivo:</th>
		</tr>
	</thead>
	<tbody>
		<!-- **** -->
	</tbody>
</table>

<?php
include_once 'footer.php';
?>
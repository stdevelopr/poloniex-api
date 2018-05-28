<?php 
include 'connect_db_pg.php';

// $sql = "DELETE FROM Data";
// $result = pg_query($conn, $sql);


$sql2 = "Select * FROM Data";
$result2 = pg_query($conn, $sql2);
while($row = pg_fetch_array($result2)) {
	print_r($row['pair']);
	echo '<br>';
	}


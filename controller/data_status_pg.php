<?php

ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$sql = 'SELECT min(date_time) FROM Data';
$result = pg_query($conn, $sql);


if($s= pg_fetch_array($result)){
	if($s['min'] !=NULL){	
		$unix_time = $s['min'];
		echo 'First entry';
		echo '<br>';
		echo 'Unix time:'.$unix_time;
		echo '<br>';
		echo 'Date: ';
		echo gmdate('d-m-Y H:i:s', $unix_time);
		echo '<br>';
		echo '<br>';
	
$max = 'SELECT max(date_time) FROM Data';
$result_max = pg_query($conn, $max);


$m= pg_fetch_array($result_max);
	if($m['max'] !=NULL){	
		$unix_time = $m['max'];
		echo 'Last entry';
		echo '<br>';
		echo 'Unix time:'.$unix_time;
		echo '<br>';
		echo 'Date: ';
		echo gmdate('d-m-Y H:i:s', $unix_time);
		echo '<br>';
		echo '<br>';
	}

$sql = 'SELECT * FROM Coins';


$result = pg_query($conn, $sql);

//atualize the screen
ob_implicit_flush(true);
ob_end_flush();

$r=0; //table number of rows
while($row = pg_fetch_array($result)) {  //the function fetch_assoc() fetch the first element from the collection.
    	$pair = $row['pair'];
    	$sql = 'SELECT * FROM Data WHERE pair='."'$pair'";
    	$output = pg_query($conn, $sql);
    	$c=0; //number of each pair
    	echo '<br>';
    	while($row2 = pg_fetch_array($output)){
			$c++;
			$r++;
    	}
    	echo $pair.': ';
    	echo $c.' Entries';
		// while($ro = $output->fetch_assoc()){
		// 	print_r($ro['pair']);
		// 	echo '<br>';
		// 	$i++;
		// 	echo $i;
		// }
    	
}
echo '<br>';
echo '<br>';
echo 'Total number of rows:'.$r;

}else{
	echo 'No entries found';
}
}

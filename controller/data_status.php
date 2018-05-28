<?php

ob_start();
include 'connect_db.php';
ob_end_clean();

$sql = 'SELECT min(date_time) FROM Data';

$result = $conn->query($sql); 

while($row = $result->fetch_assoc()){
	$unix_time = $row['min(date_time)'];
	echo 'First entry';
	echo '<br>';
	echo 'Unix time:'.$unix_time;
	echo '<br>';
	echo 'Date: ';
	echo gmdate('d-m-Y H:i:s', $unix_time);
	echo '<br>';
	echo '<br>';
}

$sql = 'SELECT max(date_time) FROM Data';

$result = $conn->query($sql); 

while($row = $result->fetch_assoc()){
	$unix_time = $row['max(date_time)'];
	echo 'Last update';
	echo '<br>';
	echo 'Unix time:'.$unix_time;
	echo '<br>';
	echo 'Date: ';
	echo gmdate('d-m-Y H:i:s', $unix_time);
	echo '<br>';
	echo '<br>';
}


$sql = 'SELECT * FROM Coins';


$result = $conn->query($sql);  

//atualize the screen
ob_implicit_flush(true);
ob_end_flush();

$r=0; //table number of rows
while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
    	$pair = $row['pair'];
    	$sql = 'SELECT * FROM Data WHERE pair='."'$pair'";
    	$output = $conn->query($sql); 
    	$c=0;
    	while($row2 = $output->fetch_assoc()){
    		$c++;
    		$r++;
    	}
    	echo $pair.': ';
    	echo $c.' Entries';
		echo '<br>';
		// while($ro = $output->fetch_assoc()){
		// 	print_r($ro['pair']);
		// 	echo '<br>';
		// 	$i++;
		// 	echo $i;
		// }
    	
}
echo 'Total number of rows:'.$r;
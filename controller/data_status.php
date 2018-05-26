<?php

include 'connect_db.php';

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
}


$sql = 'SELECT * FROM Coins';


$result = $conn->query($sql);  

//atualize the screen
ob_implicit_flush(true);
ob_end_flush();


while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
    	$pair = $row['pair'];
    	$sql = 'SELECT * FROM Data WHERE pair='."'$pair'";
    	$output = $conn->query($sql); 
		print_r($output);
		echo '<br>';
		// while($ro = $output->fetch_assoc()){
		// 	print_r($ro['pair']);
		// 	echo '<br>';
		// 	$i++;
		// 	echo $i;
		// }
    	
}

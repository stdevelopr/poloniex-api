<?php 
use LupeCode\phpTraderNative\Trader as Trader;

require_once '../vendor/autoload.php';

include 'connect_db.php';
$time_start = microtime(true);



//Execute various queries on database
// $coins = 'SELECT * FROM Coins';
// $get = $conn->query($coins);

// if ($get->num_rows > 0) {
//     // output data of each row
//     while($row = $get->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
//     	$pair = $row['pair'];
//     	$sql = 'SELECT pair, close FROM Data WHERE pair="'.$pair.'"';
//     	$result = $conn->query($sql); 
    	
//     	// if ($result->num_rows > 0) {
// //     // output data of each row
// 	    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
// 	    	foreach ($row as $key => $value) {
// 	    		print_r($row);
// 	    		echo '<br>';
// 	    	}
// 	    }
//     }
// } //Execute various queries on database  END.




// Execute only one query on the database

// select all columns from database
$sql = 'SELECT pair, date_time, close FROM Data';
// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.
if ($result->num_rows > 0) {
$data = array(); //data array store the values(date_time, close) for each pair
// output data of each row
    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
    	foreach ($row as $key => $value) {
    		$data[$row['pair']][$row['date_time']] = $row['close'];
    	}
    }
} else {
    echo "0 results";
}

//Apply macd indicator
foreach ($data as $key => $value) {
	$pair = $key;
	$close = [];
	foreach ($value as $key => $value2) {
		array_push($close, $value2);
	}

	//enter the close values to macd
	$macd_get = Trader::macd($close);
	// echo '<br>';
	// echo '<br>';

	$values = $macd_get['MACDHist'];
	$i=0;
	$c=0;
	for(end($values); key($values)!=null; prev($values)){
			// print_r(current($values));
			// echo '<br>';
			if(current($values) >0 && $c==0){
				// print_r(current($values));
				// echo 'OK';
				$i++;				
			} elseif(current($values)<0 && $i==0){
				// print_r(current($values));
				// echo 'NEG';
				// echo '<br>';
				// echo '<br>';
				$c++;

			} elseif(current($values)<0 && $i!=0){
				// print_r(current($values));
				// echo 'FIM: '.$i*4;
				// echo '<br>';
				// echo '<br>';
				break;
			} elseif(current($values) >0 && $c!=0){
				// print_r(current($values));
				// echo 'FIM: '.$c;
				// echo '<br>';
				// echo '<br>';
				break;
			}
			// echo '<br>';
	}
	if($i>0){
		$status='positive';
		$time = ($i*4).'hrs';
	}else{
		$status='negative';
		$time =  ($c*4).'hrs';
	}

	echo 'Pair :'.$pair.'<br>';
	echo 'MACD Signal: '.$status.'<br>';
	echo 'Last Cross: '.$time;
	echo '<br><br>';



	// foreach ($macd_get as $key => $value) {
	// 	print_r($value);
	// 	echo '<br>';
	// 	echo '<br>';
	// 	echo '<br>';
	// 	for(end($value); key($value)!=null; prev($value)){
	// 		print_r(current($value));
	// 		// echo '<br>';
	// 		if(current($value) >0){
	// 			echo 'OK';
				
	// 		}
	// 		echo '<br>';
	// 	}
	// };
	// // print_r(array_slice($macd_get['MACD'], -1));
	// echo '<br>';
	// echo '<br>';
};

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo '<b>Total Execution Time:</b> '.$time;
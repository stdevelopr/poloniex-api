<?php 

include 'connect_db.php';

// Actual Time
$end = date('U');

// Period to query
$period = 14400; //4hrs

// Numer of candles to retrieve
$n_candles = 10;

$start = $end - $period*$n_candles;

$sql = 'SELECT * FROM Coins';

// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.

//atualize the screen
ob_implicit_flush(true);
ob_end_flush();

// initialize curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// the function num_rows() checks if there are more than zero rows returned
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
    	$pair = $row['pair'];
    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$start.'&end='.$end.'&period='.$period;
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$get=curl_exec($ch);
		//decode
		$data = json_decode($get, true);
		//echo
		echo $pair;
		echo '<br>';
        print_r($data[0]);
        echo '<br>';
        print_r($data[1]);
        echo '<br>';
        flush();
        usleep(500000);
    }
} else {
    echo "0 results";
}

// Closing
curl_close($ch);


// //loop through the array and print the values
// foreach($ticker as $value=>$pair){
// 	print_r($value);
// 	echo '<br>';
// 	print_r($pair['date']);
// 	echo '<br>';
// 	print_r($pair['close']);
// 	$ins = "INSERT INTO `Ticker`(`date_time`, `close`) VALUES ('$pair[date]','$pair[close]')";
// 	if($conn->query($ins) === TRUE){
// 			print_r($value);
// 			echo '<br>';
// 			print_r($pair);
// 			echo '<br>';
// 	}else{
// 		echo "Error: " . $ins . "<br>" . $conn->error;
// 	};
// }
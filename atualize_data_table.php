<?php 

include 'connect_db.php';

// Actual Time
$actual = date('U');
echo 'Actual Time: '.date("F j, Y, g:i a", $actual);
echo '<br>';

// Period to query
$period = 14400; //4hrs

// Numer of candles to retrieve
$n_candles = 200;

$start = $actual - $period*$n_candles;

$sql = 'SELECT MAX(date_time) FROM Data';

// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.

// // the function num_rows() checks if there are more than zero rows returned
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$last = $row['MAX(date_time)'];
 	echo 'Last update: '.date("F j, Y, g:i a", $last);
 	echo '<br><br>';
 	if($actual > $last+14400){
 		$sql = 'SELECT * FROM Coins';

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
		    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$start.'&end='.$actual.'&period='.$period;
				// Set the url
				curl_setopt($ch, CURLOPT_URL,$url);
				// Execute
				$get=curl_exec($ch);
				//decode
				$data = json_decode($get, true);
		        //loop through the array
		        foreach ($data as $key => $value) {
		            $date = $value['date'];
		            $high = $value['high'];
		            $low = $value['low'];
		            $open = $value['open'];
		            $close = $value['close'];
		            $volume = $value['volume'];
		            $quoteVolume = $value['quoteVolume'];
		            $weightedAverage = $value['weightedAverage'];
		            $ins = "INSERT INTO Data (pair, date_time, high, low, open, close, volume, quoteVolume, weightedAverage) VALUES ('$pair', '$date', '$high', $low, $open, $close, $volume, $quoteVolume, $weightedAverage)";
		            if($conn->query($ins) === TRUE){
		                echo 'Adding '.$pair.' Date_time: '.$date.'<br>';
		            }
		        }
		        usleep(250000);
		    }
		} else {
		    echo "0 coins listed. Verify the table coins.";
		}
		echo 'Completed';
		// Closing
		curl_close($ch);


 	}else{
 		echo 'UP TO DATE!';
 	}
 };
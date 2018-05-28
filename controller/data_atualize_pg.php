<?php 

ob_start();
include 'connect_db_pg.php';
ob_end_clean();

//last update
$sql = 'SELECT max(date_time) FROM Data';
$result = pg_query($conn, $sql);
$max = pg_fetch_array($result);
$last = $max['max'];
echo 'Last update: ';
echo gmdate('d-m-Y H:i:s', $last);
echo '<br>';

//first entry
$sql = 'SELECT min(date_time) FROM Data';
$result = pg_query($conn, $sql);
$min = pg_fetch_array($result);
$first = $min['min'];


//Period to query
$period = 14400; //4hrs

//next update
$next = $last + $period;
echo 'Next update: ';
echo gmdate('d-m-Y H:i:s', $next);
echo '<br>';
echo '<br>';


//Actual Time
$actual = date('U');
echo 'Actual Time: '.date("d-m-Y H:i:s", $actual);
echo '<br>';
echo '<br>';

if($actual > $next){
	echo 'Updating...';
	echo '<br>';
	echo '<br>';
	$sql = 'SELECT * FROM Coins';

	$result = pg_query($conn, $sql);
	$atualize = false;

	ob_implicit_flush(true);
	ob_end_flush();

	// set curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	if (pg_num_rows($result)>1) {
	    // output data of each row
	    while($row = pg_fetch_array($result)) { 
	    	$pair = $row['pair'];
	    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$next.'&end='.$next.'&period='.$period;
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$get=curl_exec($ch);
			//decode
			$data = json_decode($get, true);
	        //loop through the array
	        foreach ($data as $key => $value) {
	        	$date = $value['date'];
            	if($date!=0){
            		$atualize = true;
		            $date = $value['date'];
		            // echo $pair.':'.$date;
		            $high = $value['high'];
		            $low = $value['low'];
		            $open = $value['open'];
		            $close = $value['close'];
		            $volume = $value['volume'];
		            $quoteVolume = $value['quoteVolume'];
		            $weightedAverage = $value['weightedAverage'];
		            $ins = "INSERT INTO Data (pair, date_time, high, low, open, close, volume, quoteVolume, weightedAverage) VALUES ('$pair', '$date', '$high', $low, $open, $close, $volume, $quoteVolume, $weightedAverage)";
		            $add = pg_query($conn, $ins);
	                if($add) {
	                    echo 'Adding: '.$pair.' Date_time: '.$date.'<br>';
		                $remove = "DELETE FROM Data WHERE date_time= $first";
		                $rem= pg_query($conn, $remove);
		                if($rem){
		                	 echo 'Removing '.$pair.' Date_time '.$first;
		                	 echo '<br>';
		                	 echo '<br>';
		                }
	                }
	        	}
	        }
	        usleep(250000);
	    }
	} else {
	    echo "No coins listed. Verify the table coins.";
	}

	if($atualize){
		echo 'Completed';
		echo '<br>';
		echo '<br>';
	} else{
		echo 'No data';
	}
	// Closing
	curl_close($ch);

}
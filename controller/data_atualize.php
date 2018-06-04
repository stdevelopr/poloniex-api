<!-- Atualize MySQL data table -->

<?php 
ob_start();
include 'connect_db.php';
ob_end_clean();

//last update
$sql = 'SELECT max(date_time) FROM Data';
$result = $conn->query($sql); 
$max = $result->fetch_assoc();
$last = $max['max(date_time)'];
echo 'Last update: ';
echo gmdate('d-m-Y H:i:s', $last);
echo '<br>';

//first entry
$sql = 'SELECT min(date_time) FROM Data';
$result = $conn->query($sql); 
$min = $result->fetch_assoc();
$first = $min['min(date_time)'];


//Period to query
$period = 14400; //4hrs

//next update
$next = $last + $period;
echo 'Next update: ';
echo gmdate('d-m-Y H:i:s', $next);
echo '<br>';
echo '<br>';


//Actual Time
$actual = gmdate('U');
echo 'Actual Time: '.gmdate("d-m-Y H:i:s", $actual);
echo '<br>';
echo '<br>';

if($actual > $next){
	echo 'Updating...';
	echo '<br>';
	echo '<br>';
	$sql = 'SELECT * FROM Coins';

	$result = $conn->query($sql);
	$atualize = false;

	ob_implicit_flush(true);
	ob_end_flush();

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	$pair = $row['pair'];
	    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$last.'&end='.$actual.'&period='.$period;

			curl_setopt($ch, CURLOPT_URL,$url);
			$get=curl_exec($ch);

			$data = json_decode($get, true);

	        foreach ($data as $key => $value) {
	        	$date = $value['date'];
            	if($date!=0){
            		$atualize = true;
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
		                //To mantain the size of the table...
		                // $remove = "DELETE FROM Data WHERE date_time= $first";
		                // $rem= $conn->query($remove);
		                // if($rem){
		                // 	 echo 'Removing '.$pair.' Date_time '.$first;
		                // 	 echo '<br>';
		                // 	 echo '<br>';
		            }

		            //correct the values of the last entry
		            if($date==$last){
		                $actualize_table = "UPDATE Data SET close =".$close.",low=".$low.",high=".$high." WHERE pair='".$pair."' and date_time=".$date;
					    if($conn->query($actualize_table) === TRUE){
					    	echo 'Actualizing: '. $pair.' Date_time: '.$date;
					    	echo '<br>';
					    }
					}
	        	}
	        }
	        usleep(250000);
	    }
	} else {
	    echo "0 coins listed. Verify the table coins.";
	}

	if($atualize){
		echo 'Completed';
		echo '<br>';
		echo '<br>';
	} else{
		echo 'No data';
	}

	curl_close($ch);

} else{
	echo 'Up to date!';
}
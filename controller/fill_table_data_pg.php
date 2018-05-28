<?php 

ob_start();
include 'connect_db_pg.php';
ob_end_clean();


$time_start = microtime(true);

// Actual Time
$end = date('U');

// Period to query
$period = 14400; //4hrs

// Numer of candles to retrieve
$n_candles = 150;

$start = $end - $period*$n_candles;

$sql = 'SELECT * FROM Coins';

$end = $start + $period*2;

$result = pg_query($conn, $sql);
//atualize the screen
ob_implicit_flush(true);
ob_end_flush();

// initialize curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if(pg_num_rows($result)>1){
    // output data of each row
    while($row = pg_fetch_array($result)) {
    	$pair = $row['pair'];
    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$start.'&end='.$end.'&period='.$period;
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$get=curl_exec($ch);
		//decode
		$data = json_decode($get, true);
        //loop through the array
        foreach ($data as $key => $value) {
            $date = $value['date'];
            if($date!=0){;
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
                }
            }
        }
        usleep(250000);
    }
    echo 'Completed';
    echo '<br>';
    echo '<br>';
} else {
    echo "No coins found...";
}
// Closing
curl_close($ch);


$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo '<b>Total Execution Time:</b> '.$execution_time.'s';

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo '<b>Total Execution Time:</b> '.$time;
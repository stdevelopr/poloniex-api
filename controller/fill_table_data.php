<!-- Fill MySQL Data table -->
<?php 
ob_start();
include 'connect_db.php';
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

$result = $conn->query($sql);

ob_implicit_flush(true);
ob_end_flush();

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) { 
    	$pair = $row['pair'];
    	$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$start.'&end='.$end.'&period='.$period;
		curl_setopt($ch, CURLOPT_URL,$url);
		$get=curl_exec($ch);
		$data = json_decode($get, true);
        foreach ($data as $key => $value) {
            $date = $value['date'];
            if($date!=0){
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
        }
        usleep(250000);
    }
} else {
    echo "0 coins listed. Verify the table coins.";
}
echo 'Completed';
echo '<br>';
echo '<br>';

curl_close($ch);

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo '<b>Total Execution Time:</b> '.$execution_time.'s';

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo '<b>Total Execution Time:</b> '.$time;
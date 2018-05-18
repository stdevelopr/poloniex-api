<?php 
include 'connect_db.php';

// Actual Time
$end = date('U');

// Period to query
$period = 14400; //4hrs

// Numer of candles to retrieve
$n_candles = 10;

$start = $end - $period*$n_candles;

// Chosen pair
$pair = 'BTC_XMR';

//To get all pairs
// $url= 'https://poloniex.com/public?command=returnTicker';

// Url to query
$url= 'https://poloniex.com/public?command=returnChartData&currencyPair='.$pair.'&start='.$start.'&end='.$end.'&period='.$period;
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Convert to an Json array
$ticker = json_decode($result, true);

//loop through the array and print the values
foreach($ticker as $value=>$pair){
				print_r($value);
			echo '<br>';
			print_r($pair['date']);
			echo '<br>';
			print_r($pair['close']);
	$ins = "INSERT INTO `Ticker`(`date_time`, `close`) VALUES ('$pair[date]','$pair[close]')";
	if($conn->query($ins) === TRUE){
			print_r($value);
			echo '<br>';
			print_r($pair);
			echo '<br>';
	}else{
		echo "Error: " . $ins . "<br>" . $conn->error;
	};
}





	// $ins = "INSERT INTO `Ticker`(`pair`, `last`) VALUES ('$value','$pair[last]')";
	// if($conn->query($ins) === TRUE){
	// 		print_r($value);
	// 		echo '<br>';
	// 		print_r($pair);
	// 		echo '<br>';
	// }else{
	// 	echo "Error: " . $ins . "<br>" . $conn->error;
	// };
// }
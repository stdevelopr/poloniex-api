<?php 

ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$url= 'https://poloniex.com/public?command=returnTicker';

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

ob_implicit_flush(true);
ob_end_flush();

$ticker = json_decode($result, true);

foreach($ticker as $value=>$pair){
	if(substr($value, 0, 4) === 'BTC_'){
		$ins = "INSERT INTO Coins (pair) VALUES ('$value')";
		$result = pg_query($conn, $ins);
 		if($result) {
		    echo 'Added: ';
			print_r($value);
			echo '<br>';
		} else {
		    echo "Error...";
		    echo '<br>';
		}
	}
}
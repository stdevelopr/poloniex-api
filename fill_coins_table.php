<?php 

include 'connect_db.php';

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

// Convert to an Json array
$ticker = json_decode($result, true);

foreach($ticker as $value=>$pair){
	$ins = "INSERT INTO Coins (pair) VALUES ('$value')";
	if($conn->query($ins) === TRUE){
			print_r($value);
			echo '<br>';
			// print_r($pair);
			// echo '<br>';
	}else{
		echo "Error: " . $ins . "<br>" . $conn->error;
	}
}
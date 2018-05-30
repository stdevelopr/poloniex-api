<!-- Fill PostgreSQL Coins table -->
<?php 
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$url= 'https://poloniex.com/public?command=returnTicker';

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);

$result=curl_exec($ch);

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
echo 'Completed!';
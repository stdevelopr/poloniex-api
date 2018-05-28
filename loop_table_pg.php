<?php 
use LupeCode\phpTraderNative\Trader as Trader;

require_once 'vendor/autoload.php';

$vendorDir = dirname(dirname(__FILE__));


ob_start();
include $vendorDir.'/poloniex-api/controller/connect_db_pg.php';
ob_end_clean();

// $time_start = microtime(true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="shortcut icon" href="/favicon.ico">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<!-- TableSorter -->
	<script src="js/tablesorter.js"></script>
	<!-- Initialize TableSorter -->
	<script>
		$(document).ready(function(){
			$('#pol_table').tablesorter();
		});
	</script>
</head>
<body>
<table class="table table-striped table-dark table-hover" id="pol_table">
  <thead>
    <tr>
      <th scope="col">Pair</th>
      <th scope="col">MACDSignal</th>
      <th scope="col">Last Cross</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <!-- <tr>
      <th scope="row">BTC_AMP</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr> -->
<?
// select all columns from database
$sql = 'SELECT pair, date_time, close FROM Data';
// runs the query and puts the resulting data into a variable
$result = pg_query($conn, $sql);  //A variable $results has a collection of rows which are returned by a query.
if (pg_num_rows($result)>1) {
$data = array(); //data array store the values(date_time, close) for each pair
// output data of each row
    while($row = pg_fetch_array($result)) {  //the function fetch_assoc() fetch the first element from the collection.
    	foreach ($row as $key => $value) {
    		$data[$row['pair']][$row['date_time']] = $row['close'];
    	}
    }
} else {
    echo "0 results";
}

//Apply macd indicator
foreach ($data as $key => $value) {
	$pair = $key;
	$close = [];
	foreach ($value as $key => $value2) {
		array_push($close, $value2);
	}

	//enter the close values to macd
	$macd_get = Trader::macd($close);
	// echo '<br>';
	// echo '<br>';

	$values = $macd_get['MACDHist'];
	$i=0;
	$c=0;
	for(end($values); key($values)!=null; prev($values)){
			// print_r(current($values));
			// echo '<br>';
			if(current($values) >0 && $c==0){
				// print_r(current($values));
				// echo 'OK';
				$i++;				
			} elseif(current($values)<0 && $i==0){
				// print_r(current($values));
				// echo 'NEG';
				// echo '<br>';
				// echo '<br>';
				$c++;

			} elseif(current($values)<0 && $i!=0){
				// print_r(current($values));
				// echo 'FIM: '.$i*4;
				// echo '<br>';
				// echo '<br>';
				break;
			} elseif(current($values) >0 && $c!=0){
				// print_r(current($values));
				// echo 'FIM: '.$c;
				// echo '<br>';
				// echo '<br>';
				break;
			}
			// echo '<br>';
	}
	if($i>0){
		$status='positive';
		$time = ($i*4);
	}else{
		$status='negative';
		$time =  ($c*4);
	}
	echo'
	<tr>
    <th scope="row">'.$pair.'</th>
    <td class='.$status.'>'.$status.'</td>
    <td>'.$time.'</td>
    <td>@mdo</td>
    </tr>';
	// echo '<div class=line>';
	// echo '<p>Pair :'.$pair.'</p>';
	// echo '<p>MACD Signal: '.$status.'</p>';
	// echo '<p>Last Cross: '.$time.'</p>';
	// echo '</div>';
	// echo '<br><br>';



	// foreach ($macd_get as $key => $value) {
	// 	print_r($value);
	// 	echo '<br>';
	// 	echo '<br>';
	// 	echo '<br>';
	// 	for(end($value); key($value)!=null; prev($value)){
	// 		print_r(current($value));
	// 		// echo '<br>';
	// 		if(current($value) >0){
	// 			echo 'OK';
				
	// 		}
	// 		echo '<br>';
	// 	}
	// };
	// // print_r(array_slice($macd_get['MACD'], -1));
	// echo '<br>';
	// echo '<br>';
};

// $time_end = microtime(true);
// $execution_time = ($time_end - $time_start);
// echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';

// $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
// echo '<b>Total Execution Time:</b> '.$time;
?>
  </tbody>
</table>

</body>
</html>
<?php 
use LupeCode\phpTraderNative\Trader as Trader;


$vendorDir = dirname(dirname(__FILE__));

require_once $vendorDir.'/vendor/autoload.php';
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="shortcut icon" href="/favicon.ico">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<!-- TableSorter -->
	<script src="../js/tablesorter.js"></script>
	<script src="../js/script.js"></script>
	<script>
		$(document).ready(function(){
			$('#pol_table').tablesorter();
			$('tr').click(function(event) {
    		var pair = event.currentTarget.id;
    		plot(pair);
		});
		});
	</script>

</head>
<body>
<table class="table table-striped table-dark table-hover" id="pol_table">
  <thead class="first_row">
    <tr>
      <th scope="col">Pair</th>
      <th scope="col">Histogram</th>
      <th scope="col">Last Cross</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
<?
$sql = 'SELECT pair, date_time, close FROM Data';
$result = pg_query($conn, $sql);
if (pg_num_rows($result)>1) {
$data = array();
    while($row = pg_fetch_array($result)) {
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

	$macd_get = Trader::macd($close);
	$values = $macd_get['MACDHist'];
	$i=0;
	$c=0;
	for(end($values); key($values)!=null; prev($values)){

			if(current($values) >0 && $c==0){
				$i++;				
			} elseif(current($values)<0 && $i==0){
				$c++;

			} elseif(current($values)<0 && $i!=0){
				break;
			} elseif(current($values) >0 && $c!=0){
				break;
			}
	}
	if($i>0){
		$status='positive';
		$time = ($i*4);
	}else{
		$status='negative';
		$time =  ($c*4);
	}
	echo'
	<tr id="'.$pair.'">
    <th scope="row">'.$pair.'</th>
    <td class="'.$status.'">'.$status.'</td>
    <td>'.$time.'</td>
    <td>@stdevelpr</td>
    </tr>';
};
?>
  </tbody>
</table>
</body>
</html>
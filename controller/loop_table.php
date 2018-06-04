<!-- Loop MySQL table and display the main page -->

<?php 
use LupeCode\phpTraderNative\Trader as Trader;

$vendorDir = dirname(dirname(__FILE__));

require_once $vendorDir.'/vendor/autoload.php';
ob_start();
include 'connect_db.php';
ob_end_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MACD Hunter</title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="shortcut icon" type="image/png" href="../images/favicon.png">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<!-- TableSorter -->
	<script src="../js/tablesorter.js"></script>
	<script src="../js/script.js"></script>
	<!-- on row click -->
	<script>
		$(document).ready(function(){
			$('#pol_table').tablesorter();
			$('.row_class').click(function(event) {
    		var pair = event.currentTarget.id;
    		plot(pair);
		});
		});
	</script>

</head>
<body>
<div id="header" class="row d-none d-sm-block">
	<div class="row d-none d-sm-block m-0">
		<img class="col-sm-3 m-3 ml-5" src="../images/poloniex.png" alt="">
		<img class="col-sm-4 m-3" src="../images/macd_hunter.png" alt="">
	</div>
</div>
<table class="table table-striped table-dark table-hover m-0" id="pol_table">
  <thead class="first_row">
    <tr>
      <th scope="col">Pair</th>
      <th scope="col">Histogram</th>
      <th scope="col">Last Cross<br>4h.step</th>
      <th scope="col">MACD>0</th>
    </tr>
  </thead>
  <tbody>
<?
$sql = 'SELECT pair, date_time, close FROM Data ORDER BY date_time ASC';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$data = array();
    while($row = $result->fetch_assoc()) { 
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
	$macd = $macd_get['MACD'];
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

	if(end($macd)>0){
		$signal= 'yes';
	}else{
		$signal = 'no';
	}

	echo'
	<tr class="row_class" id="'.$pair.'">
    <th scope="row">'.$pair.'</th>
    <td class="'.$status.'">'.$status.'</td>
    <td>'.$time.'</td>
    <td class="'.$signal.'">'.$signal.'</td>
    </tr>';
};
?>
  </tbody>
</table>

<table id="table_support" class="table table-striped table-dark table-hover border border-info m-0"> 
	<tr class="bg-info">
		<th>Support</th>
		<th> Wallet </th>
		<th> Address</th>
		<th>COPY</th>
	</tr>
    <tr>
        <td><img class="support_coin" src="../images/btc.png" alt=""></td>
        <td>BITCOIN</td>
        <td id="p1">1H2fFA2EMe9VQV5C2JjC5TLBpEUfkUyEdX</td>
        <td>
        	<div class="tooltiper">     
	        	<button class="btn btn-primary" onclick="copyToClipboard('#p1')" data-toggle="tooltip" data-placement="left" data-original-title="Copied!">HERE</button>
        	</div>
        </td>
    </tr>
    <tr>
        <td><img class="support_coin" src="../images/cesc.gif" alt=""></td>
        <td>CRYPTOESCUDO</td>
        <td id="p2">CcNda8xcbSsqiZjLTnHfij9w1FQS7BugHs</td>
        <td>
        	<div class="tooltiper">
	        	<button class="btn btn-primary" onclick="copyToClipboard('#p2')" data-toggle="tooltip" data-placement="left" data-original-title="Copied!">HERE</button>
        	</div>
        </td>
    </tr>
</table>

<div id="footer_p">

	<div id="suggest" class="ml-3 text-warning">
		Send your suggestions to: <p class="font-weight-bold">stdevelopr@gmail.com</p> <br>
	</div>

	<div id="fork" class="d-flex justify-content-between">
		<div class="d-inline-block text-center ml-3">
			Contact me on facebook:<br>
			<a href="https://www.facebook.com/dev.st.129">
				<img src="../images/face.png" alt=""> 
			</a>
		</div>
		<div id="tks" class="d-inline-block bottom-align-text">
			<span>****************</span>
			<h3 id="tks">Thanks for your support!</h3>
			<span>****************</span>
		</div>
		<div class="d-inline-block text-center mr-5">
			Fork me on github:<br>
			<a href="https://github.com/stdevelopr/poloniex-macd-app">
				<img src="../images/github.png" alt=""> 
			</a>
		</div>
	</div>
</div>

</body>
</html>
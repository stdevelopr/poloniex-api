<?php 
use LupeCode\phpTraderNative\Trader as Trader;

require_once 'vendor/autoload.php';

$vendorDir = dirname(dirname(__FILE__));

ob_start();
include $vendorDir.'/poloniex-api/controller/connect_db.php';
ob_end_clean();

$pair=$_GET["pair"];
echo $pair;

// select all columns from database
$sql = 'SELECT pair, date_time, close, high, low, open FROM Data WHERE pair="'.$pair.'"';

// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.

// the function num_rows() checks if there are more than zero rows returned
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
        $date_time[] = $row['date_time'];
        $formated_date[] = gmdate("Y-m-d\TH:i:s\Z", $row['date_time']);
        $high[] = $row['high'];
        $close[] = $row['close'];
        $low[] = $row['low'];
        $open[] = $row['open'];
        // $close[] = $row['close'];
    }
} else {
    echo "0 results";
}


//indicator
$ma= Trader::ma($close, 30);
$date_ma = [];
foreach ($ma as $key => $value) {
	$date_ma[$key] = $date_time[$key];
}

$macd_get = Trader::macd($close);
$macd = $macd_get['MACD'];
$macd_sig = $macd_get['MACDSignal'];
$macd_hist = $macd_get['MACDHist'];

// print_r($macd_macd);
foreach ($macd as $key => $value) {
	$date_macd[$key] = $date_time[$key];
}

?>



<head>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
<!-- Plotly chart will be drawn inside this div -->
<div id="graph"></div>
<script>
	var date_time= <?php echo json_encode($date_time); ?>;
	var close= <?php echo json_encode($close); ?>;
	var high= <?php echo json_encode($high); ?>;
	var low= <?php echo json_encode($low); ?>;
	var open= <?php echo json_encode($open); ?>;
	var ma= Object.values(<?php echo json_encode($ma); ?>);
	var date_ma= Object.values(<?php echo json_encode($date_ma); ?>);
	var macd = Object.values(<?php echo json_encode($macd); ?>);
	var macd_sig = Object.values(<?php echo json_encode($macd_sig); ?>);
	var macd_hist = Object.values(<?php echo json_encode($macd_hist); ?>);
	var date_macd = Object.values(<?php echo json_encode($date_macd); ?>);
	console.log(macd);

	var trace1 = {
		x: date_time,
		close: close,
		high: high,
		low: low,
		open: open,

		// cutomise colors
		increasing: {line: {color: 'green'}},
		decreasing: {line: {color: 'red'}},

		type: 'candlestick',
		xaxis: 'x1',
		yaxis: 'y1'
	};



	var trace2= {
	    x: date_ma,
	    y: ma,
	    type: 'scatter',
	    xaxis: 'x',
	 	yaxis: 'y1'
	  };

	  	var trace3= {
	    x: date_macd,
	    y: macd,
	    type: 'scatter',
	    xaxis: 'x',
	 	yaxis: 'y2'
	  };

	  	 var trace4= {
	    x: date_macd,
	    y: macd_sig,
	    type: 'scatter',
	    xaxis: 'x',
	 	yaxis: 'y2'
	  };

	  	var trace5= {
	    x: date_macd,
	    y: macd_hist,
	    type: 'bar',
	    xaxis: 'x',
	 	yaxis: 'y2'
	  };

	var data=[trace1, trace2, trace3, trace4, trace5];

	var layout = {
	plot_bgcolor: 'white',
	legend: {traceorder: 'reversed'},
	dragmode: 'zoom',
	showlegend: true,
	xside: 'top plot',
	xaxis: {domain: [0,1], rangeslider: {visible: false}, ticks:'outside', side: 'bottom', anchor: 'y2'},
	yaxis: {domain: [0.5,1],title: 'price',exponentformat:'none',},
	xaxis2: {domain: [0,1],rangeslider: {visible: false},ticks: 'outside',side: 'bottom', anchor: 'y2'},
	yaxis2: {domain: [0,0.2],title: 'price',exponentformat:'none',},
	};


	Plotly.plot('graph', data, layout);

</script>
</body>
</html>

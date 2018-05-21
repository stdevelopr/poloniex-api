<?php 
use LupeCode\phpTraderNative\Trader as Trader;

require_once 'vendor/autoload.php';

include 'connect_db.php';

$date_time = array();
$close = array();

// select all columns from database
$sql = 'SELECT pair, date_time, close, high, low, open FROM Data WHERE pair="BTC_AMP"';

// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.

// the function num_rows() checks if there are more than zero rows returned
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
        print_r($row);
        echo '<br>';
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

$size = sizeof($date_time);

$ma= Trader::ma($date_time, $size/4);
print_r($ma);
?>

<head>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
<!-- Plotly chart will be drawn inside this div -->
<div id="graph"></div>
<script>
	var date_time= <?php echo json_encode($formated_date); ?>;
	var close= <?php echo json_encode($close); ?>;
	var high= <?php echo json_encode($high); ?>;
	var low= <?php echo json_encode($low); ?>;
	var open= <?php echo json_encode($open); ?>;

	var trace = {
	  x: date_time,
	  close: close,
	  high: high,
	  low: low,
	  open: open,

	  // cutomise colors
	  increasing: {line: {color: 'black'}},
	  decreasing: {line: {color: 'red'}},

	  type: 'candlestick',
	  xaxis: 'x',
	  yaxis: 'y'
	};

	var trace = {
	  x: date_time,
	  close: close,
	  high: high,
	  low: low,
	  open: open,

	  // cutomise colors
	  increasing: {line: {color: 'black'}},
	  decreasing: {line: {color: 'red'}},

	  type: 'candlestick',
	  xaxis: 'x',
	  yaxis: 'y'
	};

	var data = [trace];

	var layout = {
	  dragmode: 'zoom',
	  showlegend: false,
	  xaxis: {
	    rangeslider: {
	         visible: false
	     }
	  },
	  yaxis: {
	  	title: 'price',
	  	exponentformat:'none',
	  }
	};

	Plotly.plot('graph', data, layout);
</script>
</body>
</html>

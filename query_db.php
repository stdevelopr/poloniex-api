<?php 
use LupeCode\phpTraderNative\Trader as Trader;

require_once 'vendor/autoload.php';

include 'connect_db.php';

$date_time = array();
$close = array();

// select all columns from database
$sql = 'SELECT * FROM Ticker';

// runs the query and puts the resulting data into a variable
$result = $conn->query($sql);  //A variable $results has a collection of rows which are returned by a query.

// the function num_rows() checks if there are more than zero rows returned
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  //the function fetch_assoc() fetch the first element from the collection.
        print_r($row);
        echo '<br>';
        $date_time[] = $row['date_time'];
        $close[] = $row['close'];
    }
} else {
    echo "0 results";
}

print_r($date_time);
echo '<br>';
print_r($close);
echo '<br>';
echo '<br>';
echo '<br>';

$ma= Trader::ma($close, 10);
print_r($ma);
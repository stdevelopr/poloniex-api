<?php 

ob_start();
include 'connect_db.php';
ob_end_clean();


//Create a table containing the data
$tb = 'CREATE TABLE Data(
pair varchar(15),
date_time int,
high double,
low double,
open double,
close double,
volume double,
quoteVolume double,
weightedAverage double,
PRIMARY KEY (pair, date_time)
)';
if ($conn->query($tb) === TRUE) {
    echo "Table Data created successfully";
    echo '<br>';
} else {
    echo "Error creating table: " . $conn->error;
    echo '<br>';
}
<?php 
include 'connect_db_pg.php';

//Create a table containing the data
$tb = 'CREATE TABLE Data(
pair varchar(15),
date_time int,
high real,
low real,
open real,
close real,
volume real,
quoteVolume real,
weightedAverage real,
PRIMARY KEY (pair, date_time)
)';

$result = pg_query($conn, $tb);

 if($result) {
    echo "Table Data created successfully";
    echo '<br>';
} else {
    echo "Error creating table";
    echo '<br>';
}
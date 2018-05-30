<!-- Create a PostgreSQL table containing the data -->
<?php 
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$tb = 'CREATE TABLE Data(
pair varchar(15),
date_time int NOT NULL,
high NUMERIC(9, 8),
low NUMERIC(9, 8),
open NUMERIC(9, 8),
close NUMERIC(9, 8),
volume float,
quoteVolume float,
weightedAverage NUMERIC(9, 8),
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
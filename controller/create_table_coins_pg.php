<?php 

ob_start();
include 'connect_db_pg.php';
ob_end_clean();

//Create a table containing the coins
$tb = 'CREATE TABLE Coins(
pair varchar(15) PRIMARY KEY
)';
$result = pg_query($conn, $tb);
 if($result) {
    echo "Table Coins created successfully";
    echo '<br>';
} else {
    echo "Error creating table";
    echo '<br>';
}
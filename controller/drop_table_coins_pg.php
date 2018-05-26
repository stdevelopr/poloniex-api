<?php 

ob_start();
include 'connect_db_pg.php';
ob_end_clean();


//Create a table containing the coins
$tb = 'DROP TABLE Coins';
$result = pg_query($conn, $tb);
 if($result) {
    echo "Table Coins deleted";
    echo '<br>';
} else {
    echo "Error..." . $conn->error;
    echo '<br>';
}
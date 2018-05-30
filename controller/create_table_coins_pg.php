<!-- Create a PostgreSQL table containing the coins -->
<?php 
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

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
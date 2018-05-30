<!-- Create a MySQL table containing the coins -->

<?php 

ob_start();
include 'connect_db.php';
ob_end_clean();

$tb = 'CREATE TABLE Coins(
pair varchar(15) PRIMARY KEY
)';
if ($conn->query($tb) === TRUE) {
    echo "Table Coins created successfully";
    echo '<br>';
} else {
    echo "Error creating table: " . $conn->error;
    echo '<br>';
}
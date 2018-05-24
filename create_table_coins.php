//Create mysql coins table 

<?php 

include 'connect_db.php';

//Create a table containing the coins
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
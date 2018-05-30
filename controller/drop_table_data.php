<!-- Drop MySQL Data table -->
<?php 
ob_start();
include 'connect_db.php';
ob_end_clean();

$tb = 'DROP TABLE Data';
if ($conn->query($tb) === TRUE) {
    echo "Table Data deleted";
    echo '<br>';
} else {
    echo "Error..." . $conn->error;
    echo '<br>';
}
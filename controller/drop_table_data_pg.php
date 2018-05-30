<!-- Drop PostSQL Data table -->
<?php 
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$tb = 'DROP TABLE Data';
$result = pg_query($conn, $tb);
 if($result) {
    echo "Table Data deleted";
    echo '<br>';
} else {
    echo "Error..." . $conn->error;
    echo '<br>';
}
<!-- Check the existence of the table Coins on MySQL database -->

<?php
ob_start();
include 'connect_db.php';
ob_end_clean();

$val = mysqli_query($conn,'select 1 from `Coins` LIMIT 1');
if($val == TRUE){
   echo 'OK';
}else{
   echo 'I cant find the table...';
}
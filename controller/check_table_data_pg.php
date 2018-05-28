
<?php
ob_start();
include 'connect_db_pg.php';
ob_end_clean();

$val = pg_query($conn,'select 1 from Data LIMIT 1');
if($val == TRUE){
   echo 'OK';
}else{
   echo 'I cant find the table...';
}
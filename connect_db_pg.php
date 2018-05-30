<?php
//Connect to PostgreSQL database

$con_string = "host=localhost port=5432 dbname=poloniex user=postgres password=";
// Create connection
$conn = pg_connect($con_string) or die('connection failed');;

echo 'Connected successfully to PostgreSQL <BR>';
echo 'Connection to poloniex database established<BR>';
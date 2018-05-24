<?php
//Connect to PostgreSQL database

//Server info
$server = 'localhost';
$port = '5432';
$user = 'postgres';
$pass= '';
$con_string = "host=localhost port=5432 dbname=poloniex user=postgres password=";
// Create connection
$conn = pg_connect($con_string) or die('connection failed');;

echo 'Connected successfully to Postgre <BR>';
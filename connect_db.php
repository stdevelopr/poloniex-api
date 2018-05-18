<?php

//Server info
$server = 'localhost';
$user = 'root';
$pass= '';

// Create connection
$conn = new mysqli($server, $user, $pass );

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo 'Connected successfully to mySQL. <BR>';


//Connect to the database and create one if not exists
if (mysqli_select_db($conn,'poloniex') === TRUE){
	echo 'Connection to poloniex database established';
	echo '<br>';
} else {
    echo "Couldn't connect to database: " . $conn->error;
    echo '<br>';
    echo "Creating poloniex database...";
    echo '<br>';
    $db = "CREATE DATABASE IF NOT EXISTS poloniex";
	if ($conn->query($db) === TRUE) {
    echo "Database created successfully";
    echo '<br>';
	} else {
    echo "Error creating database: " . $conn->error;
    echo '<br>';
	}
	// Select database
	if (mysqli_select_db($conn,'poloniex') === TRUE){
	echo 'Connection to poloniex database established';
	echo '<br>';
	} else {
    echo "Couldn't connect to database: " . $conn->error;
    echo '<br>';
	}
	//Create the table
	$tb = 'CREATE TABLE Ticker(
	date_time varchar(15) PRIMARY KEY,
	close float NOT NULL
	)';

	if ($conn->query($tb) === TRUE) {
	    echo "Table Ticker created successfully";
	    echo '<br>';
	} else {
	    echo "Error creating table: " . $conn->error;
	    echo '<br>';
	}
}


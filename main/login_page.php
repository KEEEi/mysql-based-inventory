<?php

//start session
session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["password"];

//use same db name as input user name
$dbName = "$user";
//make a link var to the main html page
$link_main = "main_page.html";

// build the connection
echo "Attempting to connect to DB server: $host ...";
$conn = new mysqli($host, $user, $pass, $dbName);

if( $mysqli->connect_errno) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}else{
    echo "connected"; 
}

$queryString = "create table if not exists Recipes".
               " (RecipeName char(100), Ingredient char(100), Quantity integer)";

if (! $conn->query($queryString))
   die("Error creating table: " . $conn->error() );

   $queryString = "create table if not exists Inventory".
   " (Ingredient char(100), Quantity integer)";

if (! $conn->query($queryString))
    die("Error creating table: " . $conn->error() );

//disconnected with database
$conn->close();
echo "<a href=", $link_main ,">", "Go to Main Page","</a>";
?>

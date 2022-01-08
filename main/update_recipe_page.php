<?php
//start session
session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["password"];

$dbName = "$user";
//make a link var to the main html page
$link_main = "main_page.html";

// build the connection
$conn = new mysqli($host, $user, $pass, $dbName);

//show mysql error message if could not connect 
if( $mysqli->connect_errno ) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

//create vars with user input
$name = $_POST["name"];
$ingredient = $_POST["ingredient"];
$quantity = $_POST["quant"];

//add user input to the Recipes table
$sql = "INSERT INTO Recipes (
	RecipeName, Ingredient, Quantity
) VALUES (
	'$name', '$ingredient', '$quantity'
)";

//show some message
$res = mysqli_query( $conn, $sql);
if($res){
	echo "Recipe is sucessufully added　<br/>";
}else{
	echo "Racipe is failed to add, try again　<br/>";
}

//disconnected with database
$conn->close();


echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>

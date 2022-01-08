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

//create a var with user input
$recipe = $_POST["name"];

//select whole vars in table with user input from Recipes
$stmt = $conn->prepare("SELECT * FROM Recipes WHERE RecipeName = '$recipe'");
$stmt->execute();
//recieve a result
$result = $stmt->get_result();

//shows the output of the result, which is recipe name, ingredient, and quantity
while( $row_data = $result->fetch_object() ) {
	echo "Recipe :";
	var_dump($row_data->RecipeName);
	echo"<br/>";
	echo "Ingredient :";
	var_dump($row_data->Ingredient);
	echo"<br/>";
	echo "Quantity :";
	var_dump($row_data->Quantity);
	echo"<br/>";
}

//disconnected with database
$conn->close();
echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>

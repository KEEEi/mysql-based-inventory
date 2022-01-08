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
$ingredient = $_POST["ingredient"];
$quantity = $_POST["add"];

//select whole vars in table with user input fron Inventory
$stmt = $conn->prepare("SELECT Quantity FROM Inventory WHERE Ingredient = '$ingredient'");
$stmt->execute();
$result = $stmt->get_result();
$row_data = $result->fetch_object();
//extract the Quantity from the $raw_data and store them to a var
$currentQuant = $row_data->Quantity;
$newQuant = $currentQuant + $quantity;

//if current quantity is not null
if(!is_null($currentQuant)){
	//update Inventory with new quantity
	$sql = "UPDATE Inventory SET
		Quantity = '$newQuant'
	WHERE Ingredient = '$ingredient'";
	//recieve bool
	$res = mysqli_query($conn, $sql);
	if($res){
		echo "Ingredients succesufully added<br/>";
	}else{
		echo "Failed to add<br/>";
	}
//if currentQuant has something in it
}else if(isset($currentQuant)){
	//update Inventory with new quantity
	$sql = "UPDATE Inventory SET
		Quantity = '$newQuant'
	WHERE Ingredient = '$ingredient'";
	//recieve bool
	$res = mysqli_query($conn, $sql);
	if($res){
		echo "Ingredients succesufully added<br/>";
	}else{
		echo "Failed to add<br/>";
	}
//if current quantity is null
}else if(is_null($currentQuant)){
	//insert bothe Ingredient and Quantity
	$sql = "INSERT INTO Inventory (
		Ingredient, Quantity
	) VALUES (
	'$ingredient', '$quantity'
	)";
	$res = mysqli_query($conn, $sql);
	if($res){
		echo "Ingredients succesufully added<br/>";
	}else{
		echo "Failed to add<br/>";
	}
} else{
	echo "Failed to add<br/>";
}

//disconnected with database
$conn->close();
echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>

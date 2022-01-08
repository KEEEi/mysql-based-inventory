<?php
//start session
session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$pass = $_SESSION["password"];

$dbName = "$user";
$link_main = "main_page.html";

// build the connection
$conn = new mysqli($host, $user, $pass, $dbName);

//show mysql error message if could not connect 
if( $mysqli->connect_errno ) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

//passing user input
$recipe = $_POST["name"];

//Recieve Quantity with a unser inpout name from Recipes table
$query = "SELECT Quantity FROM Recipes WHERE RecipeName = '$recipe'";
$stmt = $conn->prepare($query);

//ecxcuate a command 
$stmt->execute();
//recieve a result
$result1 = $stmt->get_result();
//fetch them to the $raw_data
$row_data = $result1->fetch_object();
//extract the Quantity from the $raw_data and store them to a var
$result1Quant = $row_data->Quantity;

//get a ingredient name from recipe table with user input
$query = "SELECT Ingredient FROM Recipes WHERE RecipeName = '$recipe'";
$stmt = $conn->prepare($query);

//ecxcuate a command 
$stmt->execute();
//recieve a result
$result2 = $stmt->get_result();
//fetch them to the $raw_data
$row_data = $result2->fetch_object();
//extract the Ingredient from the $raw_data and store them to a var
$result2Ing = $row_data->Ingredient;

//Recieve Quantity with a recipe name from Inventory table
$query = "SELECT Quantity FROM Inventory WHERE Ingredient = '$result2Ing'";
$stmt = $conn->prepare($query);

//ecxcuate a command 
$stmt->execute();
//recieve a result
$result3 = $stmt->get_result();
//fetch them to the $raw_data
$row_data3 = $result3->fetch_object();
//extract the Ingredient from the $raw_data and store them to a var
$result3Quant = $row_data3->Quantity;

//start transaction here
$conn->begin_transaction();
//only excute when current quantity is more than recipes quantity
if($result1Quant <= $result3Quant){
    //store a new quantity after calculate
    $ans = $result3Quant - $result1Quant;
    //update inventory
    $sql = "UPDATE Inventory SET 
        Quantity=$ans";
    if ($conn->query($sql) === TRUE){
        echo "Successfully, bought the all ingredients from the store<br/>";
        //commit here
        $conn->commit();
    }else
        echo "failed<br/>";
        //if failed, rollback right away
        $conn->rollback();
}else{
    echo"Not enough ingredients<br/>";
    $conn->rollback();
} 

//disconnected with database
$conn->close();
echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>

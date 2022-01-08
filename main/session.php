<?php

//start session
session_start();

//store user inputs to the session vars
$_SESSION["host"] = $_POST["host"];
$_SESSION["user"] = $_POST["user"];
$_SESSION["password"] = $_POST["password"];
echo"</br>";
echo "Session created, go to login page</br>";
echo "<a href=login_page.php>Login</a>";

?>

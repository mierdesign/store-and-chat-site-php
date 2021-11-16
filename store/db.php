<?php
//database_connection.php
$servername = "fdb23.biz.nf";
$username = "2856812_mier";
$password = "13wiskunde?";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $username);

// Check connection
if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error());
}

?>
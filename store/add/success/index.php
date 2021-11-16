<?php
session_start();
if(!empty($_POST["name"]) && !empty($_POST["desc"]) && !empty($_SESSION["username"]) && isset($_FILES["fileToUpload"])){



    $currentDirectory = getcwd();
    $uploadDirectory = "../../uploads/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['jpeg','jpg','png', "gif", "svg"]; // These will be the only file extensions allowed 

    $fileName = $_FILES['fileToUpload']['name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
          echo "<div class='inputstyle'>your product-image has been uploaded successfully<br>";
        } else {
          echo "An error occurred. Please contact the administrator.";
          echo "<script>window.location.href = '../'</script>";
        }
      } else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
        echo "<script>window.location.href = '../'</script>";
        die;
      }

    }

$uploadPath = substr($uploadPath, 6);

$servername = "fdb23.biz.nf";
$database = "2856812_mier"; 
$username = "2856812_mier";
$password = "13wiskunde?";
$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
try { 
  $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
} catch (PDOException $error) {
  echo 'Connection error: ' . $error->getMessage();
}
// Set the variables for the person we want to add to the database
$itemname = $_POST["name"];
$itemdesc = $_POST["desc"];
$owner = $_SESSION['username'];
// Here we create a variable that calls the prepare() method of the database object
// The SQL query you want to run is entered as the parameter, and placeholders are written like this :placeholder_name
$my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO items (itemname, itemdesc, owner, imagesrc) VALUES (:itemname, :itemdesc, :owner, :imagesrc)");
// Now we tell the script which variable each placeholder actually refers to using the bindParam() method
// First parameter is the placeholder in the statement above - the second parameter is a variable that it should refer to
$my_Insert_Statement->bindParam(':itemname', $itemname);
$my_Insert_Statement->bindParam(':itemdesc', $itemdesc);
$my_Insert_Statement->bindParam(':owner', $owner);
$my_Insert_Statement->bindParam(':imagesrc', $uploadPath);
// Execute the query using the data we just defined
// The execute() method returns TRUE if it is successful and FALSE if it is not, allowing you to write your own messages here
if ($my_Insert_Statement->execute()) {
  echo "your item has been uploaded<br><br><button class='button' onclick='goprev();'>Upload another</button><br><button class='button' onclick='mainpage();'>Go Home</button></div>";
} else {
  echo "ERROR</div>";
}
}else{
          echo "<script>window.location.href = '../'</script>";
}
?><link rel="stylesheet" href="../inputs.css">
<script>
function mainpage(){
window.location.href = '../../';
}
function goprev(){
window.location.href = '../';
}
</script>
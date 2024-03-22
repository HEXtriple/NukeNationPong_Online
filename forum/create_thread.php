<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forskalleforumnet";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connect
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the title from the POST parameters
$title = $_POST['title'];

$sql = "INSERT INTO threads (title) VALUES ('$title')";
$conn->query($sql);

// Redirect the user back to the forum page
header("Location: forum.php");
exit();
?>
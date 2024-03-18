<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forskalleforumnet";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$new_username = $_POST["username"];
$new_password = $_POST["passwd"];

$sql = "INSERT INTO users (username, passwd) VALUES ('$new_username', '$new_password')";

if ($conn->query($sql) === TRUE) {
  echo "New user created successfully";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$login_success = false;
$full_name = "";

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if($row["userId"] == $_POST["username"] && $row["passwd"] == $_POST["password"]) {
      $login_success = true;
      $full_name = $row["firstname"] . " " . $row["lastname"];
      break;
    }
  }
} else {
  echo "0 results";
}

$conn->close();

// Checks If login was successful
if ($login_success) {
  session_start();
  echo "Welcome, " . $full_name . "!";
  $_SESSION["username"] = $_POST["username"];
  $upload_html = file_get_contents('upload.html');
  echo $upload_html;
  
} else {
  echo "Login failed. Please check your username and password.";
}
?>

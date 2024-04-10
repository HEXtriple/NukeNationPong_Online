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

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if(isset($_POST["username"]) && isset($_POST["passwd"])) {
      if($row["userName"] == $_POST["username"] && password_verify($_POST["passwd"], $row["passwd"])) {
        $login_success = true;
        break;
      }
    } else {
      echo "Username or password not provided.";
      exit;
    }
  }
} else {
  echo "No users found. ";
}

$conn->close();

// Checks If login was successful
if ($login_success) {
  session_start();
  $_SESSION["userName"] = $_POST["username"];
  echo "Login successful. Welcome " . $_SESSION["userName"];
  echo "<br>";
  echo " Go to account: <a href='account.php'>Account</a>";
  echo "<br>";
  echo "Go to forum: <a href='../forum/forum.php'>Forum</a>";
  
} else {
  echo "Login failed. Please check your username and password.";
  echo "Would you like to create a new user?";
  echo "<br>";
  echo "<a href='newuser.php'>Create new user</a>";
}
?>

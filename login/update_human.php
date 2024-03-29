<!DOCTYPE html>
<html>
<body>

<h2>Update Account Information</h2>

<form id="updateForm">
  <label for="newName">New Username:</label><br>
  <input type="text" id="newName" name="newName"><br>
  <label for="newPassword">New Password:</label><br>
  <input type="password" id="newPassword" name="newPassword"><br>
  <input type="submit" value="Submit">
</form>
</body>
</html>

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
session_start();
if (isset($_POST["submit"])) {
  if(isset($_SESSION["userName"])) {
    $username = $_SESSION["userName"];
    $newName = $_POST['newName'];
    $newPassword = $_POST['newPassword'];

    $sql = "UPDATE users SET userName=?, passwd=? WHERE userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newName, $newPassword, $username);

    if ($stmt->execute()) {
      echo "Account information updated successfully.";
      $_SESSION["userName"] = $newName; // Update the session variable
    } else {
      echo "Error updating account information: " . $stmt->error;
    }
  } else {
    echo "No user is logged in.";
  }
} else {
  echo "Invalid request method.";
}
?>
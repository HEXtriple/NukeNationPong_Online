<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forskalleforumnet";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connect
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$username = $_SESSION["userName"];
$email = $_POST["email"];
$comment = $_POST["comment"];

$sql = "INSERT INTO posts (username, email, comment, time) VALUES ('$username', '$email', '$comment', now())";

if ($conn->query($sql) !== TRUE) {
  echo "Error: " . $sql . "<br>" . $conn->error;
} else {
  echo "New record created successfully";
}

$sql = "SELECT id, username, email, comment, time FROM posts ORDER BY time DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - username: " . $row["username"]. " " . $row["email"]. "<br>";
  }
}
$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum</title>
</head>
<body>

<form method="post">
  Email: <input type="text" name="email"><br>
  Comment: <textarea name="comment"></textarea><br>
  <input type="submit">
</form>
  
</body>
</html>
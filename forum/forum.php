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

// Fetch all threads
$sql = "SELECT * FROM threads";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<a href='thread.php?id=" . $row["id"] . "'>" . $row["title"] . "</a><br>";
  }
} else {
  echo "No threads";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a new thread</title>
  <script>
   
  </script>
</head>
<body>
<div id="chatbot"></div>
<button onclick="generateChatbot()">Generate Chatbot Response</button>

<form method="post" action="create_thread.php">
  Title: <input type="text" name="title"><br>
  <input type="submit" value="Create thread">
</form>
  
</body>
</html>

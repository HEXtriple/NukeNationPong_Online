<?php
// PHP Script
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

$name = $_POST["name"];
$email = $_POST["email"];
$comment = $_POST["comment"];

$sql = "INSERT INTO Guestbook (name, email, comment, time) VALUES ('$name', '$email', '$comment', now())";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "SELECT id, name, email, comment, time FROM Guestbook";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["email"]. "<br>";
    echo "Comment: " . $row["comment"]. "<br>";
    echo "Time: " . $row["time"]. "<br><br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>

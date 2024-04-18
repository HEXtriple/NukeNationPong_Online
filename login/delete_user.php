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

$sql = "SELECT id FROM users WHERE userName=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['userName']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$userId = $user['id'];

$sql = "DELETE FROM likes WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();


if ($stmt->affected_rows > 0) {
  session_destroy();
  sleep(2);
  header('Location: ../index.html');
  exit();
} else {
  echo "Error deleting account: " . $conn->error;
}
?>
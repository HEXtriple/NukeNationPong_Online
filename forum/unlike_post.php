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

$username = $_POST['username'];
$post_id = $_POST['post_id'];

// Fetch user_id from users table
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

$sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $post_id, $user_id);
$stmt->execute();
$conn->close();

// Redirect the user back to the previous page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
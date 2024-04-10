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

$post_id = $_POST['post_id'];
$user_id = $_SESSION["id"];

$sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $post_id, $user_id);
$stmt->execute();
$conn->close();
?>
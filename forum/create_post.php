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

$email = $_POST['email'];
$comment = $_POST['comment'];
$thread_id = $_POST['thread_id'];

$sql = "INSERT INTO posts (email, comment, thread_id) VALUES ('$email', '$comment', '$thread_id')";
$conn->query($sql);

// Redirect the user back to the thread page
header("Location: threads.php?id=" . $thread_id);
exit();
?>
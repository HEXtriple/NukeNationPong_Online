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

$email = $_SESSION["email"];
$comment = $_POST['comment'];
$thread_id = $_POST['thread_id'];
$username = $_SESSION["userName"];

if (!empty($email)) {
  $sql = "INSERT INTO posts (email, comment, thread_id, username) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $email, $comment, $thread_id, $username);
  $stmt->execute();

  header("Location: thread.php?id=" . $thread_id);
  exit();
} else {
  echo "Email is required to create a post.";
  echo "create email in accounts page: <a href='../login/account.php'>here</a>";
}
?>
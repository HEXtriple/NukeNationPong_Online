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

// Get the title from the POST parameters
$title = $_POST['title'];

if (empty($title)) {
  echo "<script>alert('Title cannot be empty');</script>";
} else {

  // Check if a thread with the same name already exists
  $stmt = $conn->prepare("SELECT * FROM threads WHERE title = ?");
  $stmt->bind_param("s", $title);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('A thread with the same title already exists');</script>";
  } else {
    // Insert the new thread into the database
    $stmt = $conn->prepare("INSERT INTO threads (title) VALUES (?)");
    $stmt->bind_param("s", $title);
    $stmt->execute();

    // Redirect the user back to the forum page
    header("Location: forum.php");
    exit();
  }
}
?>
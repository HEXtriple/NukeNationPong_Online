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

// Get the thread id from the GET parameters
$thread_id = $_GET['id'];

// Fetch all posts in the thread
$sql = "SELECT posts.*, COUNT(likes.id) as likes_count 
        FROM posts 
        LEFT JOIN likes ON posts.id = likes.post_id 
        WHERE posts.thread_id = ? 
        GROUP BY posts.id";$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $thread_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "username: " . $row["username"]. " >>> " . $row["email"]. "<br>";
    echo "comment: " . $row["comment"]. "<br>";
    echo "time: " . $row["time"]. "<br>";
    echo "likes: " . $row["likes_count"]. "<br>"; 
    echo "<br>";

    echo "<form method='post' action='like_post.php'>";
    echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
    echo "<input type='hidden' name='username' value='" . $_SESSION["userName"] . "'>";
    echo "<input type='submit' value='Like'>";
    echo "</form>";

    echo "<form method='post' action='unlike_post.php'>";
    echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
    echo "<input type='hidden' name='username' value='" . $_SESSION["userName"] . "'>";
    echo "<input type='submit' value='Unlike'>";
    echo "</form>";
    echo "<br>";
  }
} else {
  echo "No posts in this thread";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thread</title>
</head>
<body>

<form method="post" action="create_post.php">
  Email: <input type="text" name="email"><br>
  Comment: <textarea name="comment"></textarea><br>
  <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>"><br>
  <input type="submit">
</form>
  
</body>
</html>
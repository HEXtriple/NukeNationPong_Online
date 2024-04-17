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

//Get title from thread
$sql = "SELECT * FROM threads";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($row["id"] == $thread_id) {
      echo "<h1> Title: " . $row["title"]. "</h1>";
    }
  }
}
echo "<h2>Back to <a href='forum.php'>forum</a></h2>";
echo "<br>";

// Fetch all posts in the thread
$sql = "SELECT posts.*, users.profile_picture , COUNT(likes.id) as likes_count 
        FROM posts 
        LEFT JOIN likes ON posts.id = likes.post_id 
        INNER JOIN users ON posts.username = users.userName
        WHERE posts.thread_id = ? 
        GROUP BY posts.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $thread_id);
$stmt->execute();
$result = $stmt->get_result();



if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($row && $row['profile_picture']){
      $profile_picture = $row['profile_picture'];   
      echo'<img src="'.$profile_picture.'" alt="Profile Picture" width="50" height="50"> ';
    }else {
      echo'<img src="../login/profilePictures/default.jpeg" alt="default Profile Picture" width="50" height="50"> ';
    }
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
  Comment: <textarea name="comment"></textarea><br>
  <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>"><br>
  <input type="submit">
</form>
  
</body>
</html>
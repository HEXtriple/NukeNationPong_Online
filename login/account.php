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

if (isset($_SESSION["userName"]) && !empty($_SESSION["userName"])) {
      
    $sql = "SELECT profile_picture FROM users WHERE userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row && $row['profile_picture']){
      $profile_picture = $row['profile_picture'];
      echo'<img src="'.$profile_picture.'" alt="Profile Picture" width="100" height="100">';
    }else {
      echo'<img src="profilePictures/default.jpeg" alt="default Profile Picture" width="100" height="100"> <br>';
    }
    echo "Du är inloggad som " . $_SESSION["userName"]; 
}
else {
  header('Location: login.html');
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<form method="post">
    <input type="submit" name="delete" value="Delete Account"><br>
    <input type="submit" name="logout" value="Logout"><br>
    <input type="submit" name="update_human" value="change login details"><br> 
    <input type="submit" name="add_email" value="add email to account for forum functionality"><br> 
    <input type="submit" name="add_profile_picture" value="add profile picture to account"><br> 
    <input type="submit" name="forum" value="Forum">
    <input type="submit" name="home" value="Return Home">
  </form>
  
</body>
</html>

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
if(isset($_POST["delete"])) {
  $username = $_SESSION["userName"];

  $sql = "DELETE FROM users WHERE userName = '$username'";

  if ($conn->query($sql) === TRUE) {
    echo "Account deleted successfully";
    session_destroy();
  } else {
    echo "Error deleting account: " . $conn->error;
  }
}

if(isset($_POST["logout"])) {
  session_destroy();
  header('Location: login.html');
  exit();
}

if(isset($_POST["update_human"])) {
  header('Location: update_human.php');
  exit();
}

if(isset($_POST["add_email"])) {
  header('Location: add_email.php');
  exit();
}

if(isset($_POST["add_profile_picture"])) {
  header('Location: add_profile_picture.php');
  exit();
}

if(isset($_POST["forum"])) {
  header('Location: ../forum/forum.php');
  exit();
}
if(isset($_POST["home"])) {
  header('Location: ../index.html');
  exit();
}
$conn->close();
?>
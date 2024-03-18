<?php
session_start();
if (isset($_SESSION["userName"]) && !empty($_SESSION["userName"])) {
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
    <input type="submit" name="delete" value="Delete Account">
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
$conn->close();
?>
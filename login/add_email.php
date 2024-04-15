<!DOCTYPE html>
<html>
<body>

<h2>Add email to account</h2>

<form id="email_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="newMail">add email</label><br>
  <input type="email" id="newMail" name="newMail"><br>
  <input type="submit" name="submit" value="submit">
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
session_start();

if (isset($_POST["submit"])) {
  if(isset($_SESSION["userName"])) {
    $username = $_SESSION["userName"];
    $newMail = $_POST['newMail'];

    

    $sql = "UPDATE users SET email=? WHERE userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newMail, $username);

    if ($stmt->execute()) {
      $_SESSION["email"] = $newMail;
      echo "alert('Email added successfully.');";
      header('Location: account.php');
      exit();
    } else {
      echo "Error adding email: " . $stmt->error;
    }
  } else {
    echo "No user is logged in.";
  }
} 
?>

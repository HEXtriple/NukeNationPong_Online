<!DOCTYPE html>
<html>
  <head>
</head>
<body>
<form action="add_profile_picture.php" method="post" enctype="multipart/form-data">
  <label for="profilePicture">Profile Picture:</label>
  <input type="file" name="profilePicture" id="profilePicture">
  <input type="submit" name="submit" value="Upload">
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
  $target_dir = "profilePictures/";
  $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $username = $_SESSION["userName"];

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check size (i cannot afford)
  if ($_FILES["profilePicture"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats, only jpg, jpeg, png and gif
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  } else {
    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
      echo "The profile pictures has been uploaded.";
      $sql = "UPDATE users SET profile_picture=? WHERE userName=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $target_file, $username);

      if ($stmt->execute()) {
        echo "Profile picture updated successfully.";
      } else {
        echo "Error updating profile picture: " . $stmt->error;
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
echo "<br>";
echo "<h2>Back to <a href='account.php'>account</a></h2>";
echo "<br>";

$conn->close();
?>

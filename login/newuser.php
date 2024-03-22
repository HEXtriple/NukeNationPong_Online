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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $new_username = $_POST["username"];
  $new_password = $_POST["passwd"];

  $stmt = $conn->prepare("INSERT INTO users (userName, passwd) VALUES (?, ?)");
  $stmt->bind_param("ss", $new_username, $new_password);

  if ($stmt->execute()) {
    echo "New user created successfully";
    header('Location: login.html');
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            padding: 16px;
            background-color: white;
            margin: 0 auto;
            margin-top: 100px;
            border: 1px solid black;
            border-radius: 4px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }
        button:hover {
            opacity:1;
        }
    </style>
</head>
<body>
    <form id="loginForm" method="post">
        <div class="container">
          <label for="username"><b>Användarnamn</b></label>
          <input type="text" placeholder="Enter Username" name="username" required>
      
          <label for="passwd"><b>Lösenord</b></label>
          <input type="password" placeholder="Enter Password" name="passwd" id="passwd" required>
      
          <button type="submit">Logga in</button>
        </div>
    </form>
</body>
<script>
  document.getElementById('loginForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const passwdInput = document.getElementById('passwd');
  const hash = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(passwdInput.value));
  
  const hashedPassword = Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2, '0')).join('');
  passwdInput.value = hashedPassword;
    
  this.submit();
});
</script>
</html>
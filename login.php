<?php
// Replace these with your own database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    if (password_verify($password, $row["password"])) {
      // Password is correct, start a session and redirect to the home page
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['email'] = $email;
      header("Location: acceuil.html");
    } else {
      // Password is incorrect
      echo "Incorrect password";
    }
  }
} else {
  // Email not found
  echo "Email not found";
}
$conn->close();
?>

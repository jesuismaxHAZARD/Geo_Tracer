<?php
// Replace these with your own database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$age = $_POST['age'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email already exists
$sql_check_email = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql_check_email);

if ($result->num_rows > 0) {
  // Email already exists
  echo "Email already exists";
} else {
  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert new user
  $sql = "INSERT INTO users (fullname, age, address, phone, email, password)
  VALUES ('$fullname', '$age', '$address', '$phone', '$email', '$hashed_password')";

  if ($conn->query($sql) === TRUE) {
    // Registration successful, redirect to the login page
    header("Location: connexion.html");
  } else {
    // Error while inserting the user
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>

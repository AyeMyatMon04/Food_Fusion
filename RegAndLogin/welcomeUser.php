<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Welcome</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h2>
  <br><br>
  <p>You are successfully logged in.</p> 
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>

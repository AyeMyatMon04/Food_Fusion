<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    $errors = [];

    // Validate
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All required fields must be filled.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Check duplicates
    if (empty($errors)) {
        $sql = "SELECT id FROM newusers WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "Username or email already exists.";
        }
        mysqli_stmt_close($stmt);
    }

    // Insert if no error
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT); //Tells PHP to use the best current hashing algorithm (currently bcrypt as of PHP 8.3+).
        $sql = "INSERT INTO newusers (fullname, username, email, phone, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $email, $phone, $hash);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: MemLogin.php");
            exit;
        } else {
            $errors[] = "Failed to register user.";
        }
    }

    mysqli_close($conn);

    // Show errors
    echo "<link rel='stylesheet' href='style.css'><div class='error'><ul>";
    foreach ($errors as $e) {
        echo "<li>$e</li>";
    }
    echo "</ul><a href='MemRegPage.php'>Back to Registration</a></div>";
}
?>
<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $errors = [];

    // Check required fields
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Lookup user
    if (empty($errors)) {
        $sql = "SELECT id, fullname, password FROM newusers WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $fullname, $hashed);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed)) {
                // Login successful
                $_SESSION['user_id'] = $id;
                $_SESSION['fullname'] = $fullname;
                header("Location: welcomeUser.php");
                exit;
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No user found with that email.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);

    // Display errors
    echo "<link rel='stylesheet' href='style.css'><div class='error'><ul>";
    foreach ($errors as $e) {
        echo "<li>$e</li>";
    }
    echo "</ul><a href='MemLogin.php'>Back to Login</a></div>";
}
?>

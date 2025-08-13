<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="POST" action="MemRegProcess.php">
        <h2>Registration New User</h2>
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number">
        <input type="password" name="password" placeholder="Password (min 6 chars)" required minlength="6">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="6">
        <input type="submit" value="Register">
    </form>
</body>

</html>
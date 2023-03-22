<?php
require_once 'database/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    if ($password == $confirm_password) {
        $stmt = $conn->prepare("INSERT INTO users (FirstName, LastName, username, email, password, permission, ClientID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $client_id = 1;
        $stmt->bind_param("ssssssi", $first_name, $last_name, $user_name, $email, $password, $user_type, $client_id);

        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            $error = "Registration failed. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Passwords do not match.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register-WaterMan</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    <div class="register-form">
        <form method="POST" action="">
            <h1>Register</h1>
            <div class="content">
                <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
                <div class="input-field">
                    <input type="text" name="first_name" placeholder="First Name" autocomplete="nope" required>
                </div>
                <div class="input-field">
                    <input type="text" name="last_name" placeholder="Last Name" autocomplete="nope" required>
                </div>
                <div class="input-field">
                    <input type="text" name="username" placeholder="User Name" autocomplete="nope" required>
                </div>
                <div class="input-field">
                    <input type="email" name="email" placeholder="Email" autocomplete="nope" required>
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
                </div>
                <div class="input-field">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="new-password" required>
                </div>
                <div class="input-field">
                    <select name="user_type" required>
                        <option value="" disabled selected>User Type</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>
                <a href="login.php" class="link">Already Have an Account?</a>
            </div>
            <div class="action">
                <button type="submit" name="register" id="submit-div">Submit</button>
            </div>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>
</html>

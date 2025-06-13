<?php
// Start session
session_start();

include('db.php');
// Initialize variables
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and escape input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $role = 'user'; // Default role for new users
    // Check if username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $error = "Username or email already exists!";
    } else {
        // Insert new user
        $query = "INSERT INTO users (name, username, email, phone, gender, password) 
                  VALUES ('$name', '$username', '$email','$phone','$gender', '$password')";
        if (mysqli_query($conn, $query)) {
            $success = "Signup successful! <a href='login.php'>Login here</a>";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Successful</title>
    <link rel="stylesheet" href="success-style.css"> <!-- Optional CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f9ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .success-container {
            background: #fff;
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 128, 0, 0.2);
            text-align: center;
        }
        .success-container h1 {
            color: #2e7d32;
            margin-bottom: 10px;
        }
        .success-container p {
            color: #555;
        }
        .success-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #2e7d32;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .success-container a:hover {
            background: #256429;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Sign Up Successful!</h1>
        <p>Your account has been created successfully.</p>
        <a href="login.php">Proceed to Login</a>
    </div>
</body>
</html>

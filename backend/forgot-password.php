<?php
session_start();
include('db.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Simulate reset by showing a message
        echo "<script>alert('Password reset link (simulation) sent to $email'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('No account found with that email'); window.history.back();</script>";
    }
}

$conn->close();
?>

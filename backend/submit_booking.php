<?php
session_start();

// Database connection (PDO)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=hosteleasenew", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch data from POST request
$student_name = $_POST['student_name'];
$email = $_POST['email'];
$room_number = $_POST['room_number'];
$room_color = $_POST['room_color'];
$duration = $_POST['duration'];

$stmt = $pdo->prepare("SELECT price FROM rooms WHERE room_number = ?");
$stmt->execute([$room_number]);
$room = $stmt->fetch();

if (!$room) {
    die("Room price not found.");
}

// ✅ 2. Multiply price by duration
$price_per_month = $room['price'];
$price = $price_per_month * $duration;


// Save booking details to session before proceeding to payment
$_SESSION['room_booking'] = [
    'student_name' => $student_name,
    'email' => $email,
    'room_number' => $room_number,
    'room_color' => $room_color,
    'price' => $price,
    'duration' => $duration
];

// Redirect to the payment page
header("Location: ../payment.php");
?>

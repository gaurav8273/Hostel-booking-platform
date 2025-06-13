<?php
session_start();
print_r($_SESSION);  // Check session data

include '../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION['user'])) {
        die("Session expired or user not logged in.");
    }

    $student_email = $_SESSION['user'];

    // Debug POST data
    echo "<pre>";
    print_r($_POST);  // Check posted data
    echo "</pre>";

    // Optional: You can get these values too
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Update status
    $sql = "UPDATE mess_bookings SET status = 'Paid' WHERE student_email = ? AND status = 'Pending'";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $student_email);

    if ($stmt->execute()) {
        header("Location: payment_success.php");
        exit();
    } else {
        echo "Error updating payment status: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>

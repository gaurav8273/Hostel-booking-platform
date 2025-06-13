<?php
session_start();
include('../backend/db.php'); // Adjust path if needed
$message = '';
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_email = $conn->real_escape_string($_POST['student_email']);
    
    // Convert meal_plan array to comma-separated string
    $meal_plan_array = $_POST['meal_plan'];
    $meal_plan = $conn->real_escape_string(implode(", ", $meal_plan_array));
    
    $duration = $conn->real_escape_string($_POST['duration']);
    $total_amount = $conn->real_escape_string($_POST['total_amount']);
    $status = 'Pending';

    // Insert query
    $sql = "INSERT INTO mess_bookings (student_email, meal_plan, duration, total_amount, status, created_at) 
            VALUES ('$student_email', '$meal_plan', '$duration', '$total_amount', '$status', NOW())";

    if ($conn->query($sql) === TRUE) {
        $message = "🎉 Mess booked successfully!";
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Status</title>
    <style>
        .message-box {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            font-size: 18px;
            color: white;
            background-color: <?= isset($success) && $success ? '#2ecc71' : '#e74c3c' ?>;
        }

        .btn-payment {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
        }

        .btn-payment:hover {
            background-color:rgb(41, 145, 31);
        }

        .goback {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
        }

        .goback:hover {
           background-color:rgb(41, 185, 166);
        }
    </style>
</head>
<body>

<div class="message-box">
    <?= htmlspecialchars($message) ?>
        <br><br>
        <a href="dummy-payment.php" class="btn-payment">Proceed to Payment</a>

    <br><br>
    <a href="../backend/dashboard.php" class="goback">Go Back</a>
</div>

</body>
</html>

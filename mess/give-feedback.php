<?php
include('../backend/db.php');
session_start();

// Ensure student is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../backend/login.php");
    exit();
}

$student_email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Insert feedback into database
    $stmt = $pdo->prepare("INSERT INTO mess_feedback (email, rating, comment) VALUES (?, ?, ?)");
    $stmt->execute([$student_email, $rating, $comment]);
    $message = "✅ Feedback submitted!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <title>Mess Feedback</title>
    <link rel="stylesheet" href="../backend/header.css"/>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .feedback-box {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            animation: slideFade 0.5s ease;
        }

        .feedback-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .feedback-box input,
        .feedback-box textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-top: 10px;
            transition: border 0.3s;
        }

        .feedback-box input:focus,
        .feedback-box textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .feedback-box button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .feedback-box button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        @keyframes slideFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-msg {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="feedback-box">
    <h2>Give Mess Feedback</h2>
    <?php if (isset($message)) echo "<p class='success-msg'>$message</p>"; ?>
    <form method="POST">
        <label for="rating">Rating (1-5)</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label for="comment">Comments</label>
        <textarea name="comment" rows="4" required></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
</div>

</body>
</html>

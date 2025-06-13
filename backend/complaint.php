<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include('db.php');

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['student_name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO complaints (student_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = "✅ Complaint submitted successfully!";
        } else {
            $error = "❌ Failed to submit complaint. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "⚠️ Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lodge a Complaint - HostelEase</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<div class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Lodge a Complaint</h2>

    <?php if ($success): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="student_name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="student_name" name="student_name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Complaint Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required value="<?= isset($subject) ? htmlspecialchars($subject) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Describe your issue</label>
            <textarea class="form-control" id="message" name="message" rows="5" required><?= isset($message) ? htmlspecialchars($message) : '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit Complaint</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>

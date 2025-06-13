<?php
include('../admin/includes/db.php');
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/auth/admin-login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM mess_feedback ORDER BY id DESC");
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Mess Feedback</title>
    <link rel="stylesheet" href="../assets/css/admin-styles.css">
    <style>
        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Student Mess Feedback</h2>

<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feedbacks as $f): ?>
        <tr>
            <td><?= htmlspecialchars($f['email']) ?></td>
            <td><?= htmlspecialchars($f['rating']) ?>/5</td>
            <td><?= htmlspecialchars($f['comment']) ?></td>
            <td><?= htmlspecialchars($f['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$userEmail = $_SESSION['user'];

// Get user info
$sqlUser = "SELECT * FROM users WHERE email = '$userEmail'";
$resultUser = $conn->query($sqlUser);

if ($resultUser && $resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
} else {
    echo "<script>alert('User not found'); window.location.href='dashboard.php';</script>";
    exit();
}

// Get user's bookings
$sqlBooking = "
    SELECT rb.*, r.room_color
    FROM room_bookings rb
    LEFT JOIN rooms r ON rb.room_number = r.room_number
    WHERE rb.email = '$userEmail'
";

$resultBooking = $conn->query($sqlBooking);

// Get user's complaints
$sqlComplaints = "
    SELECT * FROM complaints
    WHERE email = '$userEmail'
    ORDER BY submitted_at DESC
";

$resultComplaints = $conn->query($sqlComplaints);

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile - HostelEase</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: auto; padding: 20px; }
        h2 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .status-pending { color: orange; font-weight: bold; }
        .status-approved { color: green; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h2>User Profile</h2>
<p><strong>Name:</strong> <?php echo htmlspecialchars( $user['name'] ?? 'N/A'); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
<p><strong>Contact:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>

<h2>Room Bookings</h2>

<?php if ($resultBooking && $resultBooking->num_rows > 0): ?>
    <table>
    <thead>
        <tr>
            <th>Room Number</th>
            <th>Room Color</th>
            <th>Duration (months)</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($booking = $resultBooking->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($booking['room_number']); ?></td>
            <td><?php echo htmlspecialchars($booking['room_color']); ?></td>
            <td><?php echo htmlspecialchars($booking['duration']); ?></td>
            <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
            <td class="status-<?php echo strtolower($booking['status']); ?>">
                <?php echo htmlspecialchars($booking['status']); ?>
            </td>
            <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p>You have no room bookings yet.</p>
<?php endif; ?>
<h2>Your Complaints</h2>

<?php if ($resultComplaints && $resultComplaints->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Complaint Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($complaint = $resultComplaints->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($complaint['subject']); ?></td>
                <td><?php echo htmlspecialchars($complaint['message']); ?></td>
                <td class="status-<?php echo strtolower($complaint['status']); ?>">
                    <?php echo htmlspecialchars($complaint['status']); ?>
                </td>
                <td><?php echo htmlspecialchars($complaint['submitted_at']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have not filed any complaints yet.</p>
<?php endif; ?>
<!-- Mess Bookings -->
<h2>Mess Bookings</h2>

<?php
$sqlMess = "SELECT * FROM mess_bookings WHERE student_email = '$userEmail'";
$resultMess = $conn->query($sqlMess);

if ($resultMess && $resultMess->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Meal Plan</th>
                <th>Duration (days)</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($mess = $resultMess->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mess['meal_plan']); ?></td>
                    <td><?php echo htmlspecialchars($mess['duration']); ?></td>
                    <td><?php echo htmlspecialchars($mess['total_amount']); ?></td>
                    <td class="status-<?php echo strtolower($mess['status']); ?>">
                        <?php echo htmlspecialchars($mess['status']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($mess['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have no mess bookings yet.</p>
<?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>

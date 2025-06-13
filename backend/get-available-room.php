<?php
header('Content-Type: application/json');
include('db.php');

if (!isset($_GET['color'])) {
    echo json_encode([]);
    exit;
}

$color = $_GET['color'];

$sql = "SELECT room_number, capacity FROM rooms WHERE room_color = ? AND status = 'Available'";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $color);
    $stmt->execute();
    $result = $stmt->get_result();

    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    echo json_encode($rooms);
} else {
    echo json_encode([]);
}
?>

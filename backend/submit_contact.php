<?php
// DB connection info
$host = 'localhost';
$dbname = 'hosteleasenew';
$user = 'root';  // XAMPP default
$pass = '';      // XAMPP default

// Connect to MySQL database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Basic validation function
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $name = validate_input($_POST['fullname'] ?? '');
    $email = validate_input($_POST['email'] ?? '');
    $subject = validate_input($_POST['subject'] ?? '');
    $message = validate_input($_POST['message'] ?? '');

    // Check required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo "Name, Email, and Message are required fields.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Prepare and bind statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Thank you for contacting us. We will get back to you soon!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include('db.php');

$userEmail = $_SESSION['user'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];

    $update = "UPDATE users SET name = ?, phone = ?, gender = ? WHERE email = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssss", $name, $phone, $gender, $userEmail);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }

    $stmt->close();
}

// Fetch user details
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found'); window.location.href='dashboard.php';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Profile - HostelEase</title>
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="header.css"/>
  <style>
    body {
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    main {
        padding: 50px 20px;
        max-width: 600px;
        margin: 0 auto;
    }

    h2 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 30px;
        color: #333;
    }

    form {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #2980b9;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1em;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #1c5980;
    }
  </style>
</head>
<body>
<?php include 'header/header.php'; ?>  

<main>
  <h2>Edit Profile</h2>
  <form method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" required>
      <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>

    <button type="submit">Update Profile</button>
  </form>
</main>

</body>
</html>

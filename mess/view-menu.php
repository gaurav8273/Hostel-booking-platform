<?php
// mess/mess-menu.php
session_start();
include('../admin/includes/db.php'); // adjust if needed

// Fetch mess menu from DB
$stmt = $pdo->query("SELECT * FROM mess_menu ORDER BY day");
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mess Menu</title>
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="../assets/css/dark-mode.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f4f6f9;
      color: #333;
    }

    .mess-container {
      max-width: 900px;
      margin: 80px auto;
      padding: 30px;
      border: 1px solid #ccc;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.6s ease;
    }

    h2 {
      text-align: center;
      font-size: 2em;
      margin-bottom: 25px;
      color: #2980b9;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .mess-table {
      width: 100%;
      border-collapse: collapse;
    }

    .mess-table th, .mess-table td {
      padding: 14px;
      border: 1px solid #ddd;
      text-align: center;
      font-size: 1.05em;
    }

    .mess-table th {
      background-color: #e9f4fb;
      color: #2980b9;
    }

    .mess-table tbody tr {
      opacity: 0;
      transform: translateY(20px);
      animation: slideUp 0.5s forwards;
    }

    .mess-table tbody tr:nth-child(odd) {
      background-color: #f9f9f9;
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .day-badge {
      background: #dff0fb;
      color: #0277bd;
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: bold;
      text-transform: uppercase;
      display: inline-block;
    }

    .top-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #2980b9;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 50%;
      font-size: 18px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    .top-btn:hover {
      background: #1c5980;
    }

    /* Dark Mode Enhancements */
    body.dark-mode {
      background-color: #121212;
      color: #f0f0f0;
    }

    body.dark-mode .mess-container {
      background: #1e1e1e;
      border-color: #333;
    }

    body.dark-mode .mess-table th {
      background-color: #2c2c2c;
      color: #90caf9;
    }

    body.dark-mode .mess-table td {
      background-color: #2a2a2a;
      color: #f0f0f0;
      border-color: #444;
    }

    body.dark-mode .day-badge {
      background: #37474f;
      color: #90caf9;
    }
    .mess{
      text-align: center;
      font-size: 2em;
      margin-bottom: 25px;
      color: #2980b9;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .book-btn {
  display: inline-block;
  background-color: #27ae60;
  color: white;
  padding: 12px 24px;
  font-size: 1.1em;
  border: none;
  border-radius: 30px;
  text-decoration: none;
  transition: background 0.3s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.book-btn:hover {
  background-color: #1e8449;
}

/* Dark Mode */
body.dark-mode .book-btn {
  background-color: #388e3c;
  color: #fff;
}

body.dark-mode .book-btn:hover {
  background-color: #2e7d32;
}

  </style>
</head>
<body>
  <div class="mess-container">
    <h2>Mess Menu</h2>
    <table class="mess-table">
      <thead>
        <tr>
          <th>Day</th>
          <th>Breakfast 🍳</th>
          <th>Lunch 🍛</th>
          <th>Dinner 🍲</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; foreach ($menu as $item): ?>
        <tr style="animation-delay: <?= $i * 0.1 ?>s">
          <td><span class="day-badge"><?= htmlspecialchars($item['day']) ?></span></td>
          <td>🍞 <?= htmlspecialchars($item['breakfast']) ?></td>
          <td>🍚 <?= htmlspecialchars($item['lunch']) ?></td>
          <td>🥘 <?= htmlspecialchars($item['dinner']) ?></td>
        </tr>
        <?php $i++; endforeach; ?>
      </tbody>
    </table>
        <div style="text-align: center; margin-top: 30px;">
      <a href="book-mess.php" class="book-btn">🍽️ Book Your Mess</a>
      <a href="../backend/room-list.php" class="book-btn">Back to the rooms</a>
    </div>

  </div>
  <!-- Back to top button -->
  <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="top-btn">↑</button>

  <!-- JS for dark mode (already loaded globally in your main JS, if needed) -->
</body>
</html>

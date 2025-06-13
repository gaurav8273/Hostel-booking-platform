<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header>
  <!-- Inside <head> -->
<link rel="stylesheet" href="../assets/css/dark-mode.css">
<link rel="stylesheet" href="../header.css">
<!-- At end of <body> or just before </body> -->
<script src="../assets/js/dark-mode-toggle.js"></script>

  <div class="header-container">
    <h1>HostelEase</h1>
    <nav>
      <ul>
        <li><a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="profile.php" class="<?= $currentPage == 'profile.php' ? 'active' : '' ?>">Profile</a></li>
        <li><a href="room-list.php" class="<?= $currentPage == 'room-list.php' ? 'active' : '' ?>">Book Room</a></li>
        <li><a href="complaint.php" class="<?= $currentPage == 'complaint.php' ? 'active' : '' ?>">Lodge Complaint</a></li>
        <li><a href="../mess/book-mess.php" class="<?= $currentPage == 'book-mess.php' ? 'active' : '' ?>">Mess Booking</a></li>
        <li><a href="../mess/view-menu.php" class="<?= $currentPage == 'view-menu.php' ? 'active' : '' ?>">View Menu</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <!-- Toggle Switch (Add this in your header or navbar) -->
<label class="switch">
  <input type="checkbox" id="darkModeToggle">
  <span class="slider round"></span>
</label>

<style>
/* Basic Toggle Button CSS */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #2196F3;
}
input:checked + .slider:before {
  transform: translateX(24px);
}
</style>

  </div>
</header>

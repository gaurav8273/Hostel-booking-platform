<?php
include('../admin/includes/db.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/auth/admin-login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM mess_bookings ORDER BY created_at DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mess Bill Records - HostelEase</title>
    <link rel="stylesheet" href="../admin/css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .mess-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 25px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        .mess-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mess-table th, .mess-table td {
            padding: 14px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .mess-table th {
            background-color: #f0f8ff;
            color: #1e6ea6;
        }

        .mess-table td {
            font-size: 0.95rem;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: bold;
        }

        .status-unpaid {
            background-color: #f8d7da;
            color: #721c24;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <!-- Top Navbar -->
     <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="../admin/dashboard.php">HostelEase</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../admin/profile.php">Profile</a></li>
                    
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="../admin/auth/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidebar & Content -->
    <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="../admin/dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../admin/manage/manage-users.php">Manage Users</a>
                                    <a class="nav-link" href="../admin/make_admin/make-admin.php">Create Admin</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Rooms
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../admin/manage/manage-rooms.php">Manage Rooms</a>
                                    <a class="nav-link" href="../admin/manage/booked-rooms.php">Booked Rooms</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayout" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Mess
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayout" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../admin/mess/view-menu.php">View Mess Menu</a>
                                    <a class="nav-link" href="view-mess-bills.php">Mess Bills</a>
                                    <a class="nav-link" href="update-menu.php">Update Mess Menu</a>
                                </nav>
                            </div>
                            <div>
                            <a class="nav-link" href="../admin/manage/manage-complaints.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Complaints
                            </a>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="../admin/stats.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
  <!-- Main Content -->
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Mess Bills</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">View Bookings & Payments</li>
        </ol>

        <div class="mess-container">
          <table class="mess-table">
            <thead>
              <tr>
                <th>Student Email</th>
                <th>Meal Plan</th>
                <th>Duration</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Booked At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $b): ?>
                <tr>
                  <td><?= htmlspecialchars($b['student_email']) ?></td>
                  <td><?= htmlspecialchars($b['meal_plan']) ?></td>
                  <td><?= $b['duration'] ?> months</td>
                  <td>₹<?= $b['total_amount'] ?></td>
                  <td>
                    <?php if ($b['status'] === 'Paid'): ?>
                      <span class="status-paid">Paid</span>
                    <?php else: ?>
                      <span class="status-unpaid">Unpaid</span>
                    <?php endif; ?>
                  </td>
                  <td><?= $b['created_at'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
    <?php include('../admin/includes/footer.php'); ?>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../admin/js/scripts.js"></script>
</body>
</html>

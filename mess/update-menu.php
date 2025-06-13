<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/auth/admin-login.php");
    exit;
}

require_once('../admin/includes/db.php');

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $day = $_POST['day'];
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $dinner = $_POST['dinner'];

    if (!empty($day) && !empty($breakfast) && !empty($lunch) && !empty($dinner)) {
        $stmt = $pdo->prepare("SELECT id FROM mess_menu WHERE day = ?");
        $stmt->execute([$day]);
        $existing = $stmt->fetch();

        if ($existing) {
            $update = $pdo->prepare("UPDATE mess_menu SET breakfast=?, lunch=?, dinner=? WHERE day=?");
            $update->execute([$breakfast, $lunch, $dinner, $day]);
            $success = "Menu updated successfully for $day.";
        } else {
            $insert = $pdo->prepare("INSERT INTO mess_menu (day, breakfast, lunch, dinner) VALUES (?, ?, ?, ?)");
            $insert->execute([$day, $breakfast, $lunch, $dinner]);
            $success = "Menu added successfully for $day.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Update Mess Menu - HostelEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="../admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Update Mess Menu</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Mess Management</li>
                    </ol>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-utensils me-1"></i>
                            Enter Menu Details
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Day</label>
                                    <select name="day" class="form-select" required>
                                        <option value="">-- Select Day --</option>
                                        <?php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        foreach ($days as $d) {
                                            echo "<option value=\"$d\">$d</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Breakfast</label>
                                    <input type="text" class="form-control" name="breakfast" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lunch</label>
                                    <input type="text" class="form-control" name="lunch" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dinner</label>
                                    <input type="text" class="form-control" name="dinner" required />
                                </div>

                                <button type="submit" class="btn btn-primary">Update Menu</button>
                            </form>
                        </div>
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

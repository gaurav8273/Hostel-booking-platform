<?php
// room-list.php
$conn = new mysqli("localhost", "root", "", "hosteleasenew");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get distinct room colors for dropdown
$colors = [];
$colorQuery = "SELECT DISTINCT room_color FROM rooms";
$colorResult = $conn->query($colorQuery);
while ($row = $colorResult->fetch_assoc()) {
    $colors[] = $row['room_color'];
}

// Check if color filter is set, and modify query accordingly
$colorFilter = isset($_GET['color']) ? $_GET['color'] : '';
$sql = "SELECT * FROM rooms WHERE status != 'Full'";

if (!empty($colorFilter)) {
    $sql .= " AND room_color = '" . $conn->real_escape_string($colorFilter) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Room List</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
            <style>
        body {
            background-color:rgb(70, 75, 80);
            font-family: 'Nunito', sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-family: 'Varela Round', sans-serif;
            color:white;
        }
        
        .rooms-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .room-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 15px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(148, 112, 112, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: var(--delay);
        }

        .room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .room-card img:hover {
            transform: scale(1.05);
        }

        .room-details {
            margin-top: 15px;
        }

        .room-details h3 {
            margin-bottom: 8px;
            color: #333;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60;
            margin-top: 8px;
        }

        .book-btn {
            background: #2980b9;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            margin-top: 12px;
            display: block;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .book-btn:hover {
            background: #1c5980;
        }

        select {
            padding: 8px 12px;
            margin: 20px 0;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .lable{
            color: white;
            font-size: 20px;
            font-family: 'Varela Round', sans-serif;
            margin-top: 20px;
        }


        
    </style>
    </head>
    <body id="page-top" style="padding-top: 80px;">
<h1>Available rooms</h1>
        <!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold" href="dashboard.php">HostelEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="room-list.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="../mess/book-mess.php">Book mess</a></li>
                <li class="nav-item"><a class="nav-link" href="../mess/view-menu.php">Mess Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="../contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<p style="color:white; text-align:center;">
    Showing <?= $result->num_rows ?> room(s)<?= $colorFilter ? " with color '$colorFilter'" : "" ?>.
</p>

<!-- Room Color Filter -->
<form method="GET" action="room-list.php" style="text-align: center;">
    <label for="color" class="lable">Filter by Room Color:</label>
    <select id="color" name="color" onchange="this.form.submit()">
        <option value="">All Colors</option>
        <?php foreach ($colors as $color): ?>
            <option value="<?= htmlspecialchars($color) ?>" <?= $color == $colorFilter ? 'selected' : '' ?>>
                <?= htmlspecialchars($color) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<div class="rooms-container">
<?php if ($result->num_rows > 0): ?>
    <?php
    $index = 0;
    while($row = $result->fetch_assoc()): 
        $delay = 0.1 * $index . 's'; // dynamic animation delay
        $imagePath = !empty($row['image']) ? '../admin/uploads/' . htmlspecialchars($row['image']) : 'uploads/default.jpg';
        $price = $row['price']; // Assuming you have a 'price' column in your rooms table
    ?>
        <div class="room-card" style="--delay: <?= $delay ?>;">
            <img src="<?= $imagePath ?>" alt="Room Image">
            <div class="room-details">
                <h3>Room <?= htmlspecialchars($row['room_number']) ?></h3>
                <p><strong>Color:</strong> <?= htmlspecialchars($row['room_color']) ?></p>
                <p><strong>Capacity:</strong> <?= htmlspecialchars($row['capacity']) ?> Person(s)</p>
                <p class="price">Price: ₹<?= number_format($price, 2) ?></p>
                <a href="book-room.php?room_number=<?= urlencode($row['room_number']) ?>" class="book-btn">Book Now</a>
            </div>
        </div>
    <?php 
    $index++;
    endwhile; 
    ?>
<?php else: ?>
    <p>No rooms available at the moment.</p>
<?php endif; ?>
</div>
        <!-- Contact-->
        <section class="contact-section bg-black">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Address</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50">Haldwani Nainital</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Email</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50"><a href="#!">developer@gmail.com</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Phone</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50">+91 7900425754</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social d-flex justify-content-center">
                    <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                    <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Your Website 2023</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>

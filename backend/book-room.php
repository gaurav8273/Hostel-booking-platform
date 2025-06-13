<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hosteleasenew", "root", "");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


// Check if room_number is passed
if (!isset($_GET['room_number'])) {
    die("Room Number is missing.");
}

$room_number = $_GET['room_number'];

// Fetch room details
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_number = ?");
$stmt->execute([$room_number]);
$room = $stmt->fetch();

if (!$room) {
    die("Room not found.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Book Room</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
						<div class="form-header">
							 <h2>Book Room <?= htmlspecialchars($room['room_number']) ?></h2>
						</div>
						<form method="POST" action="submit_booking.php">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<span class="form-label">Student Name</span>
										<input class="form-control" type="text" name="student_name" placeholder="Enter your name">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<span class="form-label">Email</span>
										<input class="form-control" type="email" name="email" placeholder="Enter your email">
									</div>
								</div>
							</div>
							<div class="form-group">
								<span class="form-label">Room Number</span>
								<input class="form-control" type="text" name="room_number" value="<?= htmlspecialchars($room['room_number']) ?>" readonly>
							</div>
							<div class="form-group">
								<span class="form-label">Room Color</span>
								<input class="form-control" type="text" name="room_color" value="<?= htmlspecialchars($room['room_color']) ?>" readonly>
							</div>
							<div class="row">
								<div class="col-sm-7">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<span class="form-label">Duration (in months)</span>
												<select name="duration" class="form-control">
													<option value="">Select Duration</option>
													<option value="1">1 Month</option>
													<option value="3">3 Months</option>
													<option value="6">6 Months</option>
													<option value="12">12 Months</option>
												</select>
												<span class="select-arrow"></span>
											</div>
										</div>
									</div>
								</div>
							</div>

                            <div class="form-group">
                                <span class="form-label">Amount to payed (Per Month)</span>
                                <input class="form-control" type="text" name="price" value="<?= htmlspecialchars($room['price']) ?>" readonly>
                                </div>
                                <input type="hidden" name="status" value="pending"> <!-- Default set to 'pending' -->
							<div class="form-btn">
								<button type="submit" class="submit-btn">Book Now</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
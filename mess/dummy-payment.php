<!-- dummy_payment.php -->
<?php
session_start();
 // Optional: if you want to store user booking info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mess Payment</title>
    <link rel="stylesheet" href="styles/payment.css"> <!-- Include CSS below -->
</head>
<body>
    <div class="payment-container">
        <h2>Mess Payment</h2>
        <form action="process_payment.php" method="POST">
            <label for="cardname">Cardholder Name:</label>
            <input type="text" name="cardname" required>

            <label for="cardnumber">Card Number:</label>
            <input type="text" name="cardnumber" maxlength="16" required>

            <label for="expiry">Expiry Date:</label>
            <input type="month" name="expiry" required>

            <label for="cvv">CVV:</label>
            <input type="password" name="cvv" maxlength="4" required>

            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>

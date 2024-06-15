<?php
// Start session
session_start();

// Include database connection file
include_once 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $booking_datetime = $_POST["booking_datetime"];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Calculate total price dynamically from session cart
    $totalPrice = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $totalPrice += $item['price'];
        }
    }

    // Store order details in the payments table
    storePaymentDetails($name, $email, $booking_datetime, $totalPrice, 'Pending', $conn);
}

// Function to store payment details in the payments table
function storePaymentDetails($name, $email, $booking_datetime, $totalPrice, $payment_status, $conn) {
    // Prepare SQL query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO payments (name, email, booking_datetime, total_amount, payment_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $email, $booking_datetime, $totalPrice, $payment_status);

    // Execute the query
    if ($stmt->execute() === TRUE) {
        // Payment details successfully stored
    } else {
        // Error occurred while storing payment details
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Additional styles for order confirmation page */
        body, html {
            height: 100%;
            margin: 0;
            background-color: #fee3ec; /* Pink background color */
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        form {
            width: 90%;
            max-width: 600px;
            border: 1px solid #000;
            padding: 20px;
            background-color: #fff; /* White form background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px; /* Add margin to ensure bottom edge is visible */
            overflow: auto; /* Add scrollbar when content exceeds the form height */
        }

        form h2 {
            text-align: center;
            text-decoration: underline; /* Underline "Your Order Details" */
            margin-bottom: 20px;
        }

        form p {
            margin-bottom: 10px;
        }

        .bank-details, .order-confirmation {
            margin-top: 20px;
        }

        .bank-details p {
            margin: 5px 0;
        }

        .instruction {
            margin-top: 20px;
        }

        .back-button {
            width: 50%; /* Narrower width for the button */
            padding: 10px;
            background-color: #fee3ec;
            color: #000;
            text-decoration: none;
            border: 1px solid #000;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <form>
        <h2>Your Order Details</h2>

        <?php if (isset($name) && isset($email) && isset($booking_datetime)): ?>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Booking Date and Time:</strong> <?php echo $booking_datetime; ?></p>
            <p><strong>Total Amount:</strong> R <?php echo $totalPrice; ?></p>
            <?php if (!empty($_SESSION['cart'])): ?>
                <p><strong>Ordered Items:</strong></p>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <li><?php echo $item['name']; ?> - R <?php echo $item['price']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <div class="bank-details">
            <h3>Banking Details</h3>
            <p><strong>Bank:</strong> FNB</p>
            <p><strong>Branch Code:</strong> 250655</p>
            <p><strong>Account Holder:</strong> Blessing MT Tshiyole</p>
            <p><strong>Account Number:</strong> 63038786399</p>
            <p><strong>Reference:</strong> Your Name</p>
            <p><strong>Email POP to:</strong> info@beauty911.co.za</p>
        </div>

        <div class="instruction">
            <h3>Order Confirmation Instructions</h3>
            <p>1. Your order will be confirmed via email once you have emailed the proof of payment.</p>
            <p>2. Please make sure to email proof of payment along with the above order details.</p>
        </div>

        <!-- Back button to navigate back to the index.html -->
        <a href="index.html" class="back-button">Back to Home</a>
    </form>
</div>

</body>
</html>

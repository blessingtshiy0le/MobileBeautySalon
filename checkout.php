<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style2.css">
  <style>
    /* Additional styling for checkout page */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; 
    }

    .checkout-container {
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid #000; /* Add border */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      width: 100%;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="datetime-local"],
    button {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .form-group input[type="datetime-local"] { 
      margin-left: -10px; /* Add left margin for email input */
    }

    button {
      background-color: #fee3ec;
      color: #000;
      font-size: 16px;
      border: 1px solid #000;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #fff;
    }

    .ordered-items {
      margin-top: 20px;
    }

    .ordered-item {
      margin-bottom: 10px;
    }
    .back-button {
      width: 20%;
      padding: 10px; 
      border: 1px solid #000;
      border-radius: 5px;
      background-color: #fee3ec;
      color: #000;
      text-decoration: none; /* Remove underline */
      display: inline-block; /* Make it inline-block to respect width */
      margin-top: 10px; /* Add some spacing */
      text-align: center; /* Center text */
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .back-button:hover {
      background-color: #fff;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="checkout-container">
    <h1>Checkout</h1>
    <form id="payment-form" action="process_order.php" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="booking_datetime">Booking Date & Time:</label>
        <input type="datetime-local" id="booking_datetime" name="booking_datetime" required>
      </div>
      <!-- Additional fields can be added here -->
      <div class="ordered-items">
        <h2>Ordered Items:</h2>
        <?php
        // Check if session has cart items
        session_start();
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
          echo "<ul>";
          foreach ($_SESSION['cart'] as $item) {
            echo "<li class='ordered-item'>{$item['name']} - R {$item['price']}</li>";
          }
          echo "</ul>";
        } else {
          echo "<p>No items in the cart.</p>";
        }
        ?>
      </div>
      <button type="submit">Proceed to Payment</button>
    </form>
    <!-- Back button -->
    <div class="back-button-container">
      <a href="cart.php" class="back-button">
        <i class="fas fa-arrow-left back-logo"></i> Back to Cart
      </a>
    </div>
  </div>
</div>

</body>
</html>

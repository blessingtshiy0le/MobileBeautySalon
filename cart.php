<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style2.css">
  <style>
    /* Additional styling for cart page */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .cart-container {
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid #000; /* Add border */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      width: 100%;
    }

    .cart-items {
      margin-top: 20px;
    }

    .cart-item {
      background-color: #f9f9f9;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #000;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .cart-item h3 {
      margin-bottom: 5px;
    }

    .checkout-btn {
      margin-top: 20px;
      padding: 10px 20px; /* Add padding to button */
      background-color: #fee3ec;
      color: #000;
      border: 1px solid #000;
      border-radius: 5px;
      cursor: pointer;
    }

    .checkout-btn:hover {
      background-color: #fff;
    }

    .remove-btn {
      background-color: #dc3545;
      color: #000;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .remove-btn:hover {
      background-color: #c82333;
    }
    .main-header {
    position: relative;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 10;
  }
  .main-info {
    color: #000000;
    padding: 1.5em 1 1em;
    text-align: left;
    position: relative;
  }
  .main-nav {
    margin: auto;
  }

  .main-nav nav {
    margin-left: 15px;
    margin-right: 15px;
    background: rgba(243, 157, 182, 0.15);
    backdrop-filter: blur(4.6px);
    -webkit-backdrop-filter: blur(4.6px);
    display: flex;
    justify-content: space-between;
  }

  .main-nav nav a {
    display: block;
    padding: 1.5rem 1rem;
    color: #000000;
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 1px;
  }
  .main-nav nav a:hover,
  .main-nav nav a:focus,
  .main-nav nav a.active {
    background-color: #efa6baa6;
  }

  .main-footer {
    font-size: 0.9rem;
    line-height: 1.5;
    padding-top: 3em;
    padding-bottom: 2em; /* Set the original padding-bottom */
    color: #000000;
    background-color: #f98cac;
    position: relative;
    top: 50px; /* Adjust the top position to lower the footer */
  }

  /* Add top margin to the product cards section */
  .products-container {
    margin-top: 50px; /* Adjust as needed */
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
  <div class="cart-container">
    <h1>Shopping cart <i class="fas fa-shopping-cart"></i></h1>
    <div class="cart-items">
      <!-- PHP code to fetch and display cart items -->
      <?php
      session_start(); // Start session if not already started
      $totalPrice = 0; // Initialize total price variable
      if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
          foreach($_SESSION['cart'] as $key => $item) {
              echo "<div class='cart-item'>";
              echo "<h3>" . $item['name'] . "</h3>";
              echo "<p>Price: R" . $item['price'] . "</p>";
              // Calculate total price dynamically
              $totalPrice += $item['price'];
              // Add delete button
              echo "<button class='remove-btn' onclick='removeItem($key)'>Remove</button>";
              // Add more details if needed
              echo "</div>";
          }
      } else {
          echo "<p>Your cart is empty</p>";
      }
      ?>
    </div>
    <!-- Display total price -->
    <div class="total-price">Total: R<?php echo number_format($totalPrice, 2); ?></div>
    <!-- Checkout button -->
    <button class="checkout-btn" onclick="checkout()">Proceed To Checkout</button>
    <!-- Back button -->
    <div class="back-button-container">
            <a href="index.html" class="back-button">
                <i class="fas fa-arrow-left back-logo"></i> Back to Home
            </a>
  </div>
</div>
 

<script>
  function checkout() {
    // Redirect to the checkout page or execute the checkout process
    // Here you can add JavaScript code to redirect or handle the checkout process
    // For now, let's assume you want to redirect to checkout.php
    window.location.href = "checkout.php";
  }

  function removeItem(index) {
    // Send an AJAX request to remove the item from the session cart
    // Here, you'll need to handle removing the item from the session cart using PHP
    // You can use the index to identify the item to remove
    // Reload the page or update the cart dynamically
    window.location.href = "remove_item.php?index=" + index;
  }
</script>

</body>
</html>

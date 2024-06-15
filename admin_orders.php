<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Additional styles for admin orders page */
        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            border: 1px solid #000;
        }
        
        th {
            background-color: #fee3ec;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #ddd;
        }
        
        /* Style for the dropdown menu */
        .status-dropdown {
            width: 100px;
            padding: 5px;
        }
        
        /* Style for action links */
        .status {
            color: #000;
            text-decoration: none;
        }
        
        .status:hover {
            color: #666;
        }

        .back-button {
            width: 20%;
            padding: 10px; 
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fee3ec;
            color: #000;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
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
    <div class="admin-panel">
        <h2>Customer Orders</h2>

        <?php
        // PHP code for displaying orders without services column
        // Include database connection file
        include_once 'db_connection.php';

        // Query to retrieve pending orders from the database
        $sql = "SELECT * FROM payments WHERE payment_status = 'Pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Booking Datetime</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["booking_datetime"]."</td>";
                echo "<td>R ".$row["total_amount"]."</td>";
                // Display a dropdown menu for status change
                echo "<td>";
                echo "<select class='status-dropdown' data-order-id='".$row["id"]."'>";
                echo "<option value='Pending' ".($row["payment_status"] == 'Pending' ? 'selected' : '').">Pending</option>";
                echo "<option value='Paid' ".($row["payment_status"] == 'Paid' ? 'selected' : '').">Paid</option>";
                echo "</select>";
                echo "</td>";
                // Display status next to the dropdown menu
                echo "<td class='status' data-order-id='".$row["id"]."'>".$row["payment_status"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No pending orders.";
        }

        $conn->close();
        ?>
        
        <!-- Back button to navigate back to the admin page -->
        <a href="admin.html" class="back-button">Back to Admin Panel</a>

    </div>
</div>

<script>
    // JavaScript for handling status update
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            let newStatus = this.value;
            let orderId = this.getAttribute('data-order-id');
            let statusCell = document.querySelector('.status[data-order-id="'+orderId+'"]');
            statusCell.textContent = newStatus;
            // Save status locally
            localStorage.setItem('orderStatus_' + orderId, newStatus);
        });
    });

    // Retrieve and update status from local storage
    document.querySelectorAll('.status').forEach(statusCell => {
        let orderId = statusCell.getAttribute('data-order-id');
        let storedStatus = localStorage.getItem('orderStatus_' + orderId);
        if(storedStatus) {
            statusCell.textContent = storedStatus;
            // Also update the dropdown menu to reflect the stored status
            let dropdown = document.querySelector('.status-dropdown[data-order-id="'+orderId+'"]');
            if(dropdown) {
                dropdown.value = storedStatus;
            }
        }
    });
</script>

</body>
</html>

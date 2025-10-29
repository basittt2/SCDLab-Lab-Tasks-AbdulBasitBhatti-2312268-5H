<?php
// orders.php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "onlineshop_lab3";
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

// Join orders, customers and sum quantities
$sql = "SELECT o.order_id, c.name AS customer_name, o.order_date, 
        COALESCE(SUM(oi.quantity),0) AS total_quantity
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.customer_id
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";
$res = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders - Online Shop</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f1f8e9);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #1565c0;
            margin-top: 50px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 85%;
            margin-top: 30px;
            overflow-x: auto;
            animation: fadeIn 0.6s ease;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1976d2;
            color: white;
            padding: 14px;
            border-bottom: 2px solid #1565c0;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: #333;
            font-size: 15px;
        }

        tr:hover {
            background: #e3f2fd;
            transition: 0.3s;
        }

        .back-btn {
            margin-top: 25px;
            display: inline-block;
            background: #1565c0;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 0 3px 10px rgba(21, 101, 192, 0.3);
        }

        .back-btn:hover {
            background: #0d47a1;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <h1>📦 All Orders</h1>

    <div class="table-container">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Total Quantity</th>
            </tr>
            <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name'] ?? 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_quantity']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a class="back-btn" href="index.php">← Back to Home</a>
</body>
</html>
<?php $mysqli->close(); ?>

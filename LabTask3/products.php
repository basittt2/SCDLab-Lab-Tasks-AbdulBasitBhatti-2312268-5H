<?php
// products.php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "onlineshop_lab3";
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$sql = "SELECT p.product_id, p.name AS product_name, c.category_name, p.price
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        ORDER BY p.product_id";
$res = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products - Online Shop</title>
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
    <h1>🛍️ Product Catalog</h1>

    <div class="table-container">
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price (PKR)</th>
            </tr>
            <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
                    <td><?php echo number_format($row['price'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a class="back-btn" href="index.php">← Back to Home</a>
</body>
</html>
<?php $mysqli->close(); ?>

<?php
// suppliers.php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "onlineshop_lab3";
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$sql = "SELECT s.name AS supplier_name, s.contact, p.name AS product_name
        FROM suppliers s
        LEFT JOIN products p ON s.product_id = p.product_id
        ORDER BY s.supplier_id";
$res = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppliers - Online Shop</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9, #e3f2fd);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #2e7d32;
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
            background: #43a047;
            color: white;
            padding: 14px;
            border-bottom: 2px solid #2e7d32;
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
            background: #e8f5e9;
            transition: 0.3s;
        }

        .back-btn {
            margin-top: 25px;
            display: inline-block;
            background: #2e7d32;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 0 3px 10px rgba(46, 125, 50, 0.3);
        }

        .back-btn:hover {
            background: #1b5e20;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <h1>🏭 Supplier Directory</h1>

    <div class="table-container">
        <table>
            <tr>
                <th>Supplier Name</th>
                <th>Contact</th>
                <th>Product Supplied</th>
            </tr>
            <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name'] ?? 'Multiple / N/A'); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a class="back-btn" href="index.php">← Back to Home</a>
</body>
</html>
<?php $mysqli->close(); ?>

<?php
// index.php
$host = "localhost";
$user = "root";
$pass = "";
$db = "onlineshop_lab3";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$customers = $mysqli->query("SELECT * FROM customers ORDER BY customer_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Shopping Management System - Home</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e3f2fd, #f9f9f9);
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1976d2;
            color: white;
            padding: 25px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        main {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        th, td {
            border: none;
            padding: 14px;
            text-align: center;
        }

        th {
            background-color: #0d47a1;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f5f9ff;
        }

        tr:hover {
            background-color: #e3f2fd;
            transition: background 0.2s ease-in-out;
        }

        .btns {
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .btn-orders { background-color: #43a047; }
        .btn-products { background-color: #fb8c00; }
        .btn-suppliers { background-color: #6a1b9a; }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 15px 0;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Online Shopping Management System</h1>
    </header>

    <main>
        <h2 style="color:#1565c0;">Customer Records</h2>

        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
            </tr>
            <?php while($row = $customers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="btns">
            <a class="btn btn-orders" href="orders.php">🛒 View Orders</a>
            <a class="btn btn-products" href="products.php">📦 View Products</a>
            <a class="btn btn-suppliers" href="suppliers.php">🏭 View Suppliers</a>
        </div>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Online Shopping Management System. All rights reserved.
    </footer>

</body>
</html>
<?php $mysqli->close(); ?>

<?php
// db_connect.php
$servername = "localhost";
$username = "root";
$password = "";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$dbname = "onlineshop_lab3";
if ($conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") === TRUE) {
    echo "Database '$dbname' created or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

// Set safe defaults
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Create tables in the correct order (InnoDB + FK support)
$create = [];

// customers
$create[] = "CREATE TABLE IF NOT EXISTS customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  phone VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// categories
$create[] = "CREATE TABLE IF NOT EXISTS categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// products
$create[] = "CREATE TABLE IF NOT EXISTS products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// orders
$create[] = "CREATE TABLE IF NOT EXISTS orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  order_date DATE,
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// order_items
$create[] = "CREATE TABLE IF NOT EXISTS order_items (
  item_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT NOT NULL DEFAULT 1,
  FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// suppliers
$create[] = "CREATE TABLE IF NOT EXISTS suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  contact VARCHAR(100),
  product_id INT,
  FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Run creation queries
foreach ($create as $sql) {
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Insert sample data only if tables are empty
function table_empty($conn, $table) {
    $res = $conn->query("SELECT COUNT(*) AS c FROM `$table`");
    if ($res) {
        $row = $res->fetch_assoc();
        return ((int)$row['c'] === 0);
    }
    return true;
}

// Insert categories (5)
if (table_empty($conn, 'categories')) {
    $conn->query("INSERT INTO categories (category_name) VALUES
        ('Electronics'),
        ('Home & Kitchen'),
        ('Clothing'),
        ('Books'),
        ('Beauty & Personal Care')"
    );
    echo "Inserted sample categories.<br>";
}

// Insert customers (10)
if (table_empty($conn, 'customers')) {
    $conn->query("INSERT INTO customers (name, email, phone) VALUES
        ('Ayaan Sheikh','ayaan.sheikh@example.com','0301-1234567'),
        ('Noor Fatima','noor.fatima@example.com','0302-2345678'),
        ('Hamza Iqbal','hamza.iqbal@example.com','0303-3456789'),
        ('Laiba Zafar','laiba.zafar@example.com','0304-4567890'),
        ('Usman Tariq','usman.tariq@example.com','0305-5678901'),
        ('Hira Saeed','hira.saeed@example.com','0306-6789012'),
        ('Daniyal Khan','daniyal.khan@example.com','0307-7890123'),
        ('Eman Raza','eman.raza@example.com','0308-8901234'),
        ('Zara Malik','zara.malik@example.com','0309-9012345'),
        ('Rehan Ali','rehan.ali@example.com','0310-0123456')
    ");
    echo "Inserted sample customers.<br>";
}


// Insert products (5)
if (table_empty($conn, 'products')) {
    // categories ids assumed 1..5
    $conn->query("INSERT INTO products (name, price, category_id) VALUES
        ('Smartphone Model A', 69999.00, 1),
        ('Electric Kettle', 3499.00, 2),
        ('Men\'s T-Shirt', 999.00, 3),
        ('PHP Programming Book', 1299.00, 4),
        ('Face Moisturizer', 799.00, 5)
    ");
    echo "Inserted sample products.<br>";
}

// Insert suppliers (5) referencing products (we created 5 products)
if (table_empty($conn, 'suppliers')) {
    $conn->query("INSERT INTO suppliers (name, contact, product_id) VALUES
        ('Metro Electronics','metro@example.com / 021-111222333', 1),
        ('HomeGoods Co.','homegoods@example.com / 021-222333444', 2),
        ('Fashion Hub','fashion@example.com / 021-333444555', 3),
        ('Book World','books@example.com / 021-444555666', 4),
        ('Beauty Supplies','beauty@example.com / 021-555666777', 5)
    ");
    echo "Inserted sample suppliers.<br>";
}

// Insert orders (5) and order_items (multiple)
if (table_empty($conn, 'orders') && table_empty($conn, 'order_items')) {
    // Insert 5 orders for different customers with dates
    $today = date('Y-m-d');
    $conn->query("INSERT INTO orders (customer_id, order_date) VALUES
        (1, DATE_SUB('$today', INTERVAL 10 DAY)),
        (2, DATE_SUB('$today', INTERVAL 8 DAY)),
        (3, DATE_SUB('$today', INTERVAL 6 DAY)),
        (4, DATE_SUB('$today', INTERVAL 4 DAY)),
        (5, DATE_SUB('$today', INTERVAL 2 DAY))
    ");

    // Fetch last inserted order IDs are sequential if empty, but to be safe pull them
    $orderIds = [];
    $res = $conn->query("SELECT order_id FROM orders ORDER BY order_id LIMIT 5");
    while ($r = $res->fetch_assoc()) { $orderIds[] = $r['order_id']; }

    // Add order_items (each order gets 1-3 items)
    // Map product ids 1..5
    $items = [
        [$orderIds[0], 1, 1], // order1: 1 x product1
        [$orderIds[0], 4, 2], // order1: 2 x product4
        [$orderIds[1], 2, 1], // order2: 1 x product2
        [$orderIds[1], 3, 2], // order2: 2 x product3
        [$orderIds[2], 5, 3], // order3: 3 x product5
        [$orderIds[3], 1, 1], // order4: 1 x product1
        [$orderIds[3], 3, 1], // order4: 1 x product3
        [$orderIds[4], 4, 1], // order5: 1 x product4
        [$orderIds[4], 2, 1]  // order5: 1 x product2
    ];

    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    foreach ($items as $it) {
        $stmt->bind_param("iii", $it[0], $it[1], $it[2]);
        $stmt->execute();
    }
    $stmt->close();

    echo "Inserted sample orders and order items.<br>";
}

// Restore FK checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<br>Setup complete. You can now open <a href='index.php'>index.php</a>.<br>";
$conn->close();
?>

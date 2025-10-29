<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $roll_no = trim($_POST['roll_no']);
    $email = trim($_POST['email']);
    $marks = trim($_POST['marks']);
    $department = trim($_POST['department']);

    if ($name && $roll_no && $email && $marks && $department) {
        // ✅ Correct use of mysqli prepare
        $stmt = $conn->prepare("INSERT INTO students (name, roll_no, email, marks, department) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $roll_no, $email, $marks, $department);

        if ($stmt->execute()) {
            $message = "✅ Student added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            text-align: center;
            margin-top: 50px;
        }
        form {
            background: #fff;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
        }
        input[type=text], input[type=number], input[type=email] {
            padding: 10px;
            width: 250px;
            margin: 10px 0;
            border: 1px solid #aaa;
            border-radius: 6px;
        }
        input[type=submit], a {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type=submit]:hover, a:hover {
            background: #0d47a1;
        }
        p {
            color: #333;
        }
    </style>
</head>
<body>

<h2>Add New Student</h2>
<p><?php echo $message; ?></p>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="text" name="roll_no" placeholder="Roll Number" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="number" name="marks" placeholder="Marks" required><br>
    <input type="text" name="department" placeholder="Department" required><br>
    <input type="submit" value="Add Student"><br><br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</form>

</body>
</html>
<?php $conn->close(); ?>

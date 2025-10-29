<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Invalid Request: Student ID is missing.");
}

$id = intval($_GET['id']);

// Fetch existing student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found!");
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $roll_no = trim($_POST['roll_no']);
    $email = trim($_POST['email']);
    $marks = trim($_POST['marks']);
    $department = trim($_POST['department']);

    if ($name && $roll_no && $email && $marks && $department) {
        $update = $conn->prepare("UPDATE students SET name=?, roll_no=?, email=?, marks=?, department=? WHERE id=?");
        $update->bind_param("sssisi", $name, $roll_no, $email, $marks, $department, $id);

        if ($update->execute()) {
            $message = "✅ Student updated successfully!";
            // Refresh data after update
            $student = ['name' => $name, 'roll_no' => $roll_no, 'email' => $email, 'marks' => $marks, 'department' => $department];
        } else {
            $message = "❌ Update failed: " . $update->error;
        }
        $update->close();
    } else {
        $message = "⚠️ All fields are required.";
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            text-align: center;
            margin-top: 50px;
        }
        form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
            display: inline-block;
        }
        input[type=text], input[type=email], input[type=number] {
            width: 250px;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #aaa;
        }
        input[type=submit], a {
            background: #1976d2;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type=submit]:hover, a:hover {
            background: #0d47a1;
        }
    </style>
</head>
<body>

<h2>Edit Student</h2>
<p><?php echo $message; ?></p>

<form method="POST">
    <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br>
    <input type="text" name="roll_no" value="<?php echo htmlspecialchars($student['roll_no']); ?>" required><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>
    <input type="number" name="marks" value="<?php echo htmlspecialchars($student['marks']); ?>" required><br>
    <input type="text" name="department" value="<?php echo htmlspecialchars($student['department']); ?>" required><br>
    <input type="submit" value="Update Student"><br><br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</form>

</body>
</html>

<?php $conn->close(); ?>

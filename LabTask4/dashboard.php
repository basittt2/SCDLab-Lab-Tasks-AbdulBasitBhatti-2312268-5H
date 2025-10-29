<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$search = '';
$orderBy = 'name';
$orderDir = 'ASC';

// Handle search & sorting
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if (in_array($sort, ['name', 'marks'])) {
        $orderBy = $sort;
    }
}
if (isset($_GET['dir']) && in_array(strtoupper($_GET['dir']), ['ASC', 'DESC'])) {
    $orderDir = strtoupper($_GET['dir']);
}

// Prepare query
$query = "SELECT * FROM students WHERE name LIKE ? OR roll_no LIKE ? ORDER BY $orderBy $orderDir";
$stmt = $conn->prepare($query);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Student Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 30px;
            text-align: center;
        }
        h2 {
            color: #0d47a1;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background: #1976d2;
            color: #fff;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        tr:hover { background: #eef5ff; }
        form {
            margin-bottom: 20px;
        }
        input[type=text] {
            padding: 8px;
            width: 250px;
            border: 1px solid #aaa;
            border-radius: 6px;
        }
        input[type=submit], .btn {
            padding: 8px 14px;
            border: none;
            background: #1976d2;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            margin: 3px;
        }
        input[type=submit]:hover, .btn:hover {
            background: #0d47a1;
        }
        .logout {
            float: right;
            margin-right: 40px;
            background: #e53935;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
<a class="btn logout" href="logout.php">Logout</a>
<br><br>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name or roll no" value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Search">
</form>

<div>
    <a class="btn" href="?sort=name&dir=<?php echo $orderDir === 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Name</a>
    <a class="btn" href="?sort=marks&dir=<?php echo $orderDir === 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Marks</a>
    <a class="btn" href="add_student.php">Add Student</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll No</th>
        <th>Email</th>
        <th>Marks</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['marks']); ?></td>
        <td><?php echo htmlspecialchars($row['department']); ?></td>
        <td>
            <a class="btn" href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a class="btn" href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

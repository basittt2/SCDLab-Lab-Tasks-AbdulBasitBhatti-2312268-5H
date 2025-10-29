<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if ID is passed
if (!isset($_GET['id'])) {
    die("Invalid Request: Student ID missing.");
}

$id = intval($_GET['id']);

// Delete record safely
$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Student deleted successfully!'); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('❌ Failed to delete student.'); window.location.href='dashboard.php';</script>";
}

$stmt->close();
$conn->close();
?>

<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare and check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "No account found with this email!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Student Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f6fc;
            text-align: center;
            margin-top: 80px;
        }
        form {
            background: #fff;
            display: inline-block;
            padding: 30px 50px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        input[type=submit] {
            background: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
        .message {
            color: red;
            margin-bottom: 10px;
        }
        a {
            display: block;
            margin-top: 12px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Login to Student Management System</h2>

<form method="POST">
    <div class="message"><?= $message ?></div>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Login">
    <a href="register.php">Don’t have an account? Register</a>
</form>

</body>
</html>

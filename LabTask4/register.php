<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password === $confirm) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: Email may already exist.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            text-align: center;
            margin-top: 60px;
        }
        form {
            background: #fff;
            padding: 30px;
            display: inline-block;
            box-shadow: 0 0 10px #ccc;
            border-radius: 10px;
        }
        input {
            margin: 10px;
            padding: 10px;
            width: 250px;
        }
        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Register</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email Address" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
    <button type="submit">Register</button>
</form>

</body>
</html>

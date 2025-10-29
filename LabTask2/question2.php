<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Strength Checker</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: #fff;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        input[type=text] {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type=text]:focus {
            border-color: #007bff;
        }
        input[type=submit] {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type=submit]:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .bar {
            height: 10px;
            width: 100%;
            background: #e0e0e0;
            border-radius: 5px;
            margin-top: 15px;
            overflow: hidden;
        }
        .bar-fill {
            height: 100%;
            width: 0;
            border-radius: 5px;
            transition: width 0.4s ease;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Password Strength Checker</h2>

    <form method="POST">
        <input type="text" name="password" placeholder="Enter your password" required>
        <br>
        <input type="submit" value="Check Strength">
    </form>

    <?php
    function check_password(string $pwd): array {
        $results = [
            'length_ok' => strlen($pwd) >= 8,
            'has_upper' => preg_match('/[A-Z]/', $pwd),
            'has_digit' => preg_match('/[0-9]/', $pwd),
            'has_special' => preg_match('/[^A-Za-z0-9]/', $pwd)
        ];

        $results['score'] = $results['length_ok'] + $results['has_upper'] + $results['has_digit'] + $results['has_special'];
        return $results;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];
        $check = check_password($password);
        $score = $check['score'];

        if ($score <= 1) {
            $strength = "Weak";
            $color = "#ff4d4d";
            $width = "25%";
        } elseif ($score == 2) {
            $strength = "Medium";
            $color = "#ffa500";
            $width = "50%";
        } elseif ($score == 3) {
            $strength = "Good";
            $color = "#32cd32";
            $width = "75%";
        } else {
            $strength = "Strong";
            $color = "#007bff";
            $width = "100%";
        }

        echo "<div class='result' style='color:$color;'>
                Password: <b>$password</b><br>Strength: <b>$strength</b>
              </div>
              <div class='bar'>
                <div class='bar-fill' style='width:$width; background:$color;'></div>
              </div>";
    }
    ?>
</div>

</body>
</html>

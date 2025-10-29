<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Student Information Processor</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f5f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            margin-top: 60px;
            width: 90%;
            max-width: 900px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #222;
            font-size: 26px;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 14px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #0078ff;
            color: white;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f8fbff;
        }

        tr:hover {
            background-color: #eef5ff;
            transition: background 0.2s ease-in-out;
        }

        /* Status color styling */
        .Excellent { color: #2ecc71; font-weight: bold; }
        .Good { color: #3498db; font-weight: bold; }
        .Pass { color: #f1c40f; font-weight: bold; }
        .Fail { color: #e74c3c; font-weight: bold; }

        footer {
            text-align: center;
            color: #555;
            margin-top: 20px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Information Summary</h2>

    <?php
    // Function to calculate average and assign status
    function processStudent(&$student) {
        $total = array_sum($student['marks']);
        $average = $total / count($student['marks']);
        $student['average'] = round($average, 2);

        if ($average >= 80) {
            $student['status'] = "Excellent";
        } elseif ($average >= 60) {
            $student['status'] = "Good";
        } elseif ($average >= 40) {
            $student['status'] = "Pass";
        } else {
            $student['status'] = "Fail";
        }

        // Assign message based on status
        switch ($student['status']) {
            case "Excellent":
                $student['message'] = "Awarded Scholarship";
                break;
            case "Good":
                $student['message'] = "Can Apply for Internship";
                break;
            case "Pass":
                $student['message'] = "Needs Improvement";
                break;
            case "Fail":
                $student['message'] = "Repeat Semester";
                break;
        }
    }

    // Student data (updated names)
    $students = [
        [
            "name" => "Sara Khan",
            "age" => 19,
            "marks" => explode(",", "85,78,90,88,92"),
            "status" => ""
        ],
        [
            "name" => "Ahmed Ali",
            "age" => (int)"22 years", // casting to integer
            "marks" => explode(",", "70,68,74,80,77"),
            "status" => ""
        ],
        [
            "name" => "Zara Malik",
            "age" => 20,
            "marks" => explode(",", "45,50,38,42,40"),
            "status" => ""
        ],
        [
            "name" => "Hamza Rehman",
            "age" => 21,
            "marks" => explode(",", "30,25,35,28,32"),
            "status" => ""
        ]
    ];

    // Process each student
    foreach ($students as &$student) {
        processStudent($student);
    }

    // Display results
    echo "<table>";
    echo "<tr><th>Name</th><th>Age</th><th>Marks</th><th>Average</th><th>Status</th><th>Message</th></tr>";

    foreach ($students as $s) {
        echo "<tr>";
        echo "<td>{$s['name']}</td>";
        echo "<td>{$s['age']}</td>";
        echo "<td>" . implode(", ", $s['marks']) . "</td>";
        echo "<td>{$s['average']}</td>";
        echo "<td class='{$s['status']}'>{$s['status']}</td>";
        echo "<td>{$s['message']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
    <footer>© 2025 Student Performance System</footer>
</div>

</body>
</html>

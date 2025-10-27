<?php
require 'auth_check.php';
require 'db.php';

// Default employee (you can add a search form later)
$emp_no = $_GET['emp_no'] ?? 10001;

// Fetch employee name
$stmt = $pdo->prepare("SELECT first_name, last_name FROM employees WHERE emp_no = ?");
$stmt->execute([$emp_no]);
$employee = $stmt->fetch();

// Fetch salary history (temporal data!)
$stmt = $pdo->prepare("
    SELECT salary, from_date, to_date 
    FROM salaries 
    WHERE emp_no = ? 
    ORDER BY from_date DESC
");
$stmt->execute([$emp_no]);
$salaries = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Salary History</title>
    <meta charset="utf-8">
    <style> 
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .nav-links {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            transition: all 0.3s ease;
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            background: #5a6268;
        }
        table { 
            border-collapse: collapse; 
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        } 
        th { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        } 
        td { 
            padding: 12px 15px; 
            border-bottom: 1px solid #eee;
        }
        tr:nth-child(even) {
            background-color: #f8f9ff;
        }
        tr:nth-child(odd) {
            background-color: #ffffff;
        }
        tr:hover {
            background-color: #e8f4f8;
            transition: background-color 0.3s ease;
        }
        .form-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }
        input[type="number"],
        input[type="date"] {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 300px;
        }
        input[type="number"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="list_employees.php" class="btn">← Back to Employee List</a>
            <a href="logout.php" class="btn" style="background: #dc3545; color: white; margin-left: 10px;">Logout</a>
        </div>
        
        <h2>Salary History for <?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?> (ID: <?= $emp_no ?>)</h2>

    <table>
        <tr><th>Salary</th><th>From Date</th><th>To Date</th></tr>
        <?php foreach ($salaries as $row): ?>
        <tr>
            <td><?= number_format($row['salary']) ?></td>
            <td><?= htmlspecialchars($row['from_date']) ?></td>
            <td><?= htmlspecialchars($row['to_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

        <div class="form-section">
            <h3>Add New Salary Record</h3>
            <form action="add_salary.php" method="post">
                <input type="hidden" name="emp_no" value="<?= $emp_no ?>">
                <div class="form-group">
                    <label>Salary: <input type="number" name="salary" min="1" required></label>
                </div>
                <div class="form-group">
                    <label>From Date: <input type="date" name="from_date" value="<?= date('Y-m-d') ?>" required></label>
                </div>
                <button type="submit">Add Salary</button>
            </form>
        </div>
    </div>
</body>
</html>
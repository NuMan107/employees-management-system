<?php
require 'auth_check.php';
require 'db.php';

$message = '';
$message_type = '';

if ($_POST) {
    try {
        $emp_no = (int)$_POST['emp_no'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $hire_date = $_POST['hire_date'];

        // Validate dates
        if (!strtotime($birth_date) || !strtotime($hire_date)) {
            throw new Exception('Invalid date format');
        }

        // Check if employee number already exists
        $check = $pdo->prepare("SELECT emp_no FROM employees WHERE emp_no = ?");
        $check->execute([$emp_no]);
        if ($check->fetch()) {
            throw new Exception('Employee number already exists');
        }

        // Insert employee
        $stmt = $pdo->prepare("
            INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$emp_no, $birth_date, $first_name, $last_name, $gender, $hire_date]);

        // Insert initial salary if provided
        if (isset($_POST['salary']) && $_POST['salary'] > 0) {
            $salary = (int)$_POST['salary'];
            $salary_date = $_POST['hire_date'];
            $stmt = $pdo->prepare("
                INSERT INTO salaries (emp_no, salary, from_date, to_date)
                VALUES (?, ?, ?, '9999-01-01')
            ");
            $stmt->execute([$emp_no, $salary, $salary_date]);
        }

        $message = 'Employee created successfully!';
        $message_type = 'success';
        
        // Clear form
        $_POST = [];

    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'error';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Employee</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .optional {
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Employee</h1>

        <?php if ($message): ?>
            <div class="message <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Employee Number *</label>
                <input type="number" name="emp_no" value="<?= $_POST['emp_no'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label>First Name *</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Last Name *</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Gender *</label>
                <select name="gender" required>
                    <option value="">Select...</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Birth Date *</label>
                <input type="date" name="birth_date" value="<?= $_POST['birth_date'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label>Hire Date *</label>
                <input type="date" name="hire_date" value="<?= $_POST['hire_date'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label>Initial Salary <span class="optional">(Optional)</span></label>
                <input type="number" name="salary" value="<?= $_POST['salary'] ?? '' ?>" min="0">
                <small class="optional">You can add salary later</small>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Create Employee</button>
                <a href="list_employees.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>


<?php
require 'auth_check.php';
require 'db.php';

if ($_POST) {
    $emp_no = (int)$_POST['emp_no'];
    $salary = (int)$_POST['salary'];
    $from_date = $_POST['from_date'];

    // Validate date format (basic)
    if (!strtotime($from_date)) {
        die('Invalid date');
    }

    try {
        // Close previous salary period (set to_date = day before new from_date)
        $pdo->prepare("
            UPDATE salaries 
            SET to_date = DATE_SUB(?, INTERVAL 1 DAY) 
            WHERE emp_no = ? AND to_date = '9999-01-01'
        ")->execute([$from_date, $emp_no]);

        // Insert new salary record (temporal validity)
        $pdo->prepare("
            INSERT INTO salaries (emp_no, salary, from_date, to_date)
            VALUES (?, ?, ?, '9999-01-01')
        ")->execute([$emp_no, $salary, $from_date]);

        // Redirect back to view
        header("Location: index.php?emp_no=$emp_no");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

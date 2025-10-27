<?php
require 'auth_check.php';
require 'db.php';

$emp_no = (int)($_GET['emp_no'] ?? 0);

if (!$emp_no) {
    header('Location: list_employees.php');
    exit;
}

try {
    // Get employee info for display
    $stmt = $pdo->prepare("SELECT first_name, last_name FROM employees WHERE emp_no = ?");
    $stmt->execute([$emp_no]);
    $employee = $stmt->fetch();

    if (!$employee) {
        header('Location: list_employees.php');
        exit;
    }

    // Note: In a production system, you'd want to cascade delete or handle related records
    // For now, we'll just delete the employee
    // You might want to add foreign key constraints or handle salaries separately
    
    // Delete salaries first (if foreign keys aren't set to CASCADE)
    $stmt = $pdo->prepare("DELETE FROM salaries WHERE emp_no = ?");
    $stmt->execute([$emp_no]);

    // Delete employee
    $stmt = $pdo->prepare("DELETE FROM employees WHERE emp_no = ?");
    $stmt->execute([$emp_no]);

    header('Location: list_employees.php?deleted=1');
    exit;

} catch (PDOException $e) {
    die('Error deleting employee: ' . $e->getMessage());
}
?>


<?php
require 'auth_check.php';
require 'db.php';

// Handle search
$search = $_GET['search'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Build query
$sql = "SELECT emp_no, first_name, last_name, gender, birth_date, hire_date 
        FROM employees";
$params = [];

if ($search) {
    $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR emp_no = ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search];
}

$sql .= " ORDER BY hire_date DESC LIMIT $per_page OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();

// Get total count for pagination
$count_sql = "SELECT COUNT(*) FROM employees";
if ($search) {
    $count_sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR emp_no = ?";
}
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($search ? ["%$search%", "%$search%", $search] : []);
$total = $count_stmt->fetchColumn();
$total_pages = ceil($total / $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee List</title>
    <meta charset="utf-8">
    <!-- ✅ University Way: External CSS File -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>
            <span>Employee Management System</span>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="create_employee.php" class="btn btn-primary">Add New Employee</a>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>
        </h1>

        <div class="search-box">
            <form method="GET" style="display: flex; width: 100%; gap: 10px;">
                <input type="text" name="search" placeholder="Search by name or employee number..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
                <?php if ($search): ?>
                    <a href="list_employees.php" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (count($employees) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Birth Date</th>
                        <th>Hire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $emp): ?>
                    <tr>
                        <td><?= $emp['emp_no'] ?></td>
                        <td><?= htmlspecialchars($emp['first_name']) ?></td>
                        <td><?= htmlspecialchars($emp['last_name']) ?></td>
                        <td><?= htmlspecialchars($emp['gender']) ?></td>
                        <td><?= $emp['birth_date'] ?></td>
                        <td><?= $emp['hire_date'] ?></td>
                        <td class="actions">
                            <a href="index.php?emp_no=<?= $emp['emp_no'] ?>" class="btn-view">View Salary</a>
                            <a href="edit_employee.php?emp_no=<?= $emp['emp_no'] ?>" class="btn-edit">Edit</a>
                            <a href="delete_employee.php?emp_no=<?= $emp['emp_no'] ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&laquo; Prev</a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" 
                           class="<?= $page == $i ? 'current' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="info">
                <p>No employees found. <a href="create_employee.php">Create one now!</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>


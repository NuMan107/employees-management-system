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
<html>
<head>
    <title>Employee List</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            padding: 10px 20px;
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
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-box input {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .search-box button {
            padding: 12px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-box button:hover {
            background: #5568d3;
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
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn-edit {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .btn-edit:hover {
            background: #218838;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .btn-view {
            background: #17a2b8;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .btn-view:hover {
            background: #138496;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #667eea;
            border-radius: 5px;
        }
        .pagination a:hover {
            background: #667eea;
            color: white;
        }
        .pagination .current {
            background: #667eea;
            color: white;
            border: 1px solid #667eea;
        }
        .info {
            text-align: center;
            color: #666;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span>Employee Management System</span>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="create_employee.php" class="btn btn-primary">Add New Employee</a>
                <a href="logout.php" class="btn" style="background: #dc3545; color: white;">Logout</a>
            </div>
        </h1>

        <div class="search-box">
            <form method="GET" style="display: flex; width: 100%; gap: 10px;">
                <input type="text" name="search" placeholder="Search by name or employee number..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
                <?php if ($search): ?>
                    <a href="list_employees.php" class="btn" style="background: #6c757d; color: white;">Clear</a>
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


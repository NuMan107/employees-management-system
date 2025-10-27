EMPLOYEE CRUD SYSTEM - USER GUIDE
=================================

I've created a complete CRUD (Create, Read, Update, Delete) system for your employee database with SECURE LOGIN SYSTEM.

FILES CREATED:
-------------
LOGIN SYSTEM:
1. login.php              - Beautiful login page with authentication
2. logout.php             - Logout functionality
3. auth_check.php         - Session protection (included in all pages)
4. setup_users.php        - Database setup for users table

EMPLOYEE MANAGEMENT:
1. list_employees.php     - Main employee listing with search and pagination
2. create_employee.php    - Add new employees
3. edit_employee.php      - Edit existing employees
4. delete_employee.php   - Delete employees (with confirmation)
5. Add_salary.php         - Add salary records

FEATURES:
---------
✓ Beautiful login screen with secure authentication
✓ Session-based access control
✓ Modern, colorful UI with gradient backgrounds
✓ Search functionality by name or employee number
✓ Pagination (10 employees per page)
✓ Full CRUD operations
✓ Validation and error handling
✓ Responsive design

SETUP AND LOGIN:
---------------
1. FIRST TIME SETUP: Run setup_users.php to create the users table
   http://localhost/employees_app/setup_users.php
   
2. DEFAULT CREDENTIALS:
   Username: admin
   Password: admin123
   
3. LOGIN: Open login.php in your browser
   http://localhost/employees_app/login.php

HOW TO USE:
----------
1. Login using the credentials above
2. You'll be redirected to the employee management dashboard
3. Use the Logout button to end your session

EMPLOYEE OPERATIONS:
------------------
1. CREATE: Click "Add New Employee" button
   - Fill in required fields
   - Optionally add initial salary
   - Click "Create Employee"

2. READ: Browse employees in the table
   - Use search box to find specific employees
   - Click "View Salary" to see salary history

3. UPDATE: Click "Edit" on any employee row
   - Modify information
   - Click "Update Employee"

4. DELETE: Click "Delete" on any employee row
   - Confirm deletion in popup
   - Employee will be removed

COLORFUL DESIGN:
---------------
The system uses:
- Purple gradient backgrounds
- Alternating row colors
- Hover effects
- Modern buttons with transitions
- Clean, professional look

NAVIGATION:
----------
- list_employees.php → Main dashboard
- index.php → View salary history for specific employee
- create_employee.php → Add new employee
- edit_employee.php → Edit employee
- delete_employee.php → Delete employee (with confirmation)

SECURITY NOTES:
--------------
✓ Password hashing using PHP's password_hash() function
✓ Session-based authentication
✓ Protected routes - all pages require login
✓ SQL injection prevention with prepared statements
✓ XSS prevention with htmlspecialchars()

⚠️ CHANGE THE DEFAULT PASSWORD IN PRODUCTION! ⚠️

Enjoy your new CRUD system with secure login!


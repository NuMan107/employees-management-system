# Employee Management System

A secure CRUD (Create, Read, Update, Delete) web application for managing employees with authentication, built with PHP and MySQL.

## 🔐 Features

- ✅ **Secure Login System** - Session-based authentication
- ✅ **SQL Injection Protection** - Using prepared statements
- ✅ **Password Security** - bcrypt hashing
- ✅ **XSS Prevention** - Input sanitization
- ✅ **Employee Management** - Full CRUD operations
- ✅ **Search & Pagination** - Efficient data browsing
- ✅ **Salary Management** - Track employee salary history
- ✅ **Modern UI** - Beautiful gradient design
- ✅ **Responsive Design** - Works on all devices

## 🏗️ Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Authentication**: Session-based
- **Security**: Prepared statements, password hashing
- **Frontend**: HTML5, CSS3, Vanilla JavaScript

## 📁 Project Structure

```
employees_app/
├── db.php                    # Database connection
├── auth_check.php            # Authentication middleware
├── login.php                 # Login page
├── logout.php                # Logout handler
├── list_employees.php        # Employee listing
├── create_employee.php       # Add employee
├── edit_employee.php         # Edit employee
├── delete_employee.php      # Delete employee
├── index.php                 # Salary history
├── Add_salary.php            # Add salary record
├── setup_users.php           # Database setup
├── styles.css                # External stylesheet
└── README.md                 # This file
```

## 🚀 Installation

### Prerequisites
- XAMPP/WAMP/LAMP (PHP 7.4+ and MySQL)
- Git (for cloning)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/employees_app.git
   cd employees_app
   ```

2. **Setup Database**
   - Create a database named `employees`
   - Or import your existing employee database
   - Run `setup_users.php` to create users table:
   ```
   http://localhost/employees_app/setup_users.php
   ```

3. **Default Login Credentials**
   - Username: `admin`
   - Password: `admin123`
   
   ⚠️ **Change password in production!**

4. **Configure Database** (if needed)
   Edit `db.php` with your database credentials:
   ```php
   $host = '127.0.0.1';
   $db   = 'employees';
   $user = 'root';
   $pass = '';
   ```

5. **Access Application**
   ```
   http://localhost/employees_app/login.php
   ```

## 🔒 Security Features

### SQL Injection Prevention
- All queries use prepared statements
- Parameter binding prevents injection attacks
- Try SQL injection? It won't work! ✅

### Password Security
- Passwords hashed with PHP's `password_hash()`
- Uses bcrypt algorithm
- Plain text passwords never stored

### Session Management
- Secure server-side sessions
- Session validation on every page
- Automatic logout on session expire

### XSS Prevention
- All output escaped with `htmlspecialchars()`
- Input validation and sanitization

## 📖 Usage Guide

### Login
1. Navigate to login page
2. Enter credentials (default: admin/admin123)
3. Access employee management dashboard

### Add Employee
1. Click "Add New Employee"
2. Fill required fields
3. Optionally add initial salary
4. Submit form

### Edit Employee
1. Click "Edit" on employee row
2. Modify information
3. Save changes

### View Salary History
1. Click "View Salary" on employee row
2. See complete salary history
3. Add new salary records

### Delete Employee
1. Click "Delete" on employee row
2. Confirm deletion
3. Employee and related records removed

## 🧪 Security Testing

This project is secure against common attacks:
- ✅ SQL Injection
- ✅ XSS (Cross-Site Scripting)
- ✅ Session Hijacking
- ✅ Password Cracking
- ✅ Direct Access

See `SECURITY_TESTING_GUIDE.md` for detailed security information.

## 🎓 Learning Resources

- **Custom PHP vs Frameworks**: See `CUSTOM_VS_FRAMEWORK.md`
- **Why External CSS**: See `WHY_EXTERNAL_CSS.md`
- **Security Testing**: See `SECURITY_TESTING_GUIDE.md`

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the MIT License.

## ⚠️ Important Notes

- **Database**: Requires existing `employees` database with tables: `employees`, `salaries`
- **Security**: Change default password before production use
- **Development**: Built for XAMPP, easily adaptable to other environments

## 🐛 Known Issues

- No rate limiting on login attempts
- No CSRF token protection (can be added)
- Manual password reset not implemented

## 🚀 Future Improvements

- [ ] Add rate limiting for brute force protection
- [ ] Implement CSRF tokens
- [ ] Add password reset functionality
- [ ] Export data to CSV/Excel
- [ ] Add user roles and permissions
- [ ] Implement advanced search filters
- [ ] Add data visualization charts
- [ ] Migration to Laravel (optional)

## 👤 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)

## 🙏 Acknowledgments

- Built with security best practices
- Prepared statements for SQL injection prevention
- Modern, responsive UI design

## 📞 Support

For support, open an issue on GitHub or contact the author.

---

**Made with ❤️ using PHP and MySQL**


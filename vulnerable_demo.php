<?php
/**
 * ⚠️ WARNING: THIS IS VULNERABLE CODE FOR EDUCATIONAL PURPOSES ONLY
 * 
 * This demonstrates what NOT to do - this code is INSECURE
 * DO NOT USE THIS IN PRODUCTION!
 */

require 'db.php';

// ❌ VULNERABLE CODE - DO NOT USE THIS
// This is what hackers would exploit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // ❌ INSECURE: Direct concatenation allows SQL injection
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    echo "<div style='background: #f8d7da; padding: 15px; border: 2px solid #721c24; margin: 20px;'>";
    echo "<strong>⚠️ INSECURE SQL:</strong> $sql";
    echo "</div>";
    
    // This would allow SQL injection attacks like:
    // Username: ' OR '1'='1' --
    // Result: SELECT * FROM users WHERE username = '' OR '1'='1' --' AND password = ''
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>⚠️ VULNERABLE Login (Educational Only)</title>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: Arial; 
            padding: 20px; 
            background: #ffe6e6;
            max-width: 800px;
            margin: 0 auto;
        }
        .warning {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .demo {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input {
            padding: 10px;
            width: 300px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        code {
            background: #f4f4f4;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="warning">
        <h1>⚠️ SECURITY DEMONSTRATION</h1>
        <p><strong>This page demonstrates VULNERABLE code for educational purposes.</strong></p>
        <p>It shows what happens when you DON'T use prepared statements.</p>
    </div>

    <div class="demo">
        <h2>Try These SQL Injection Attacks:</h2>
        
        <form method="POST">
            <p>Username: <input type="text" name="username" value="admin' OR '1'='1' --"></p>
            <p>Password: <input type="password" name="password" value="anything"></p>
            <button type="submit">Show Vulnerable SQL</button>
        </form>

        <h3>Other Attack Attempts:</h3>
        <ul>
            <li><code>' OR '1'='1' --</code> → Bypasses authentication</li>
            <li><code>'; DROP TABLE users; --</code> → Deletes table</li>
            <li><code>admin' --</code> → Comments out password check</li>
            <li><code>1' UNION SELECT * FROM users --</code> → Data extraction</li>
        </ul>

        <h3>Why the Real System is Safe:</h3>
        <p>The actual <code>login.php</code> uses:</p>
        <pre><code>// ✅ SECURE
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
</code></pre>
        <p>The <code>?</code> placeholder treats input as <strong>data</strong>, not SQL code!</p>
    </div>
</body>
</html>


<?php
include 'config.php';

// --- DAY 7: BRUTE FORCE PROTECTION ---
$max_attempts = 5;
$lockout_time = 120; // 2 minutes = 120 seconds

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = 0;
}

// Check if user is locked out
if ($_SESSION['login_attempts'] >= $max_attempts) {
    $time_left = ($_SESSION['last_attempt'] + $lockout_time) - time();
    if ($time_left > 0) {
        die("<h2 style='color:red; text-align:center; margin-top:50px'>⛔ Too many failed attempts!<br>Brute Force Blocked!<br>Try again in $time_left seconds.</h2><p style='text-align:center'><a href='secure_login.php'>Refresh page</a> | <a href='logout.php'>Reset Session</a></p>");
    } else {
        // Time passed, reset
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt'] = 0;
    }
}

// --- DAY 3,4,6: LOGIN WITH ALL PROTECTIONS ---
if (isset($_POST['username'])) {
    
    // DAY 6: CSRF CHECK
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        die("<h3 style='color:red'>❌ CSRF Attack Detected! Token Invalid</h3><p><a href='secure_login.php'>Go back</a></p>");
    }

    // DAY 3: PREPARED STATEMENT (Blocks SQL Injection)
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // DAY 4: HASH VERIFICATION
        if (password_verify($_POST['password'], $row['password'])) {
            // SUCCESS - Reset brute force counter
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_attempt'] = 0;
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $_POST['username'];
            
            header("Location: dashboard.php");
            exit();
        }
    }
    
    // FAILED LOGIN
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt'] = time();
    $left = $max_attempts - $_SESSION['login_attempts'];
    
    if ($left <= 0) {
        echo "<h3 style='color:red'>Login FAILED! You are now locked for 2 minutes.</h3>";
    } else {
        echo "<h3 style='color:red'>Login FAILED! Attempt {$_SESSION['login_attempts']}/$max_attempts. $left attempts left.</h3>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Secure Login - Final</title></head>
<body style="font-family:Arial; max-width:400px; margin:50px auto; border:1px solid #ccc; padding:20px;">
<h2>🔒 Secure Login<br><small>SQLi + Hash + CSRF + Brute Force Protected</small></h2>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    Username: <input type="text" name="username" required style="width:100%; padding:8px;"><br><br>
    Password: <input type="password" name="password" required style="width:100%; padding:8px;"><br><br>
    <button type="submit" style="width:100%; padding:10px; background:green; color:white; border:none;">Login Securely</button>
</form>

<p><a href="secure_register.php">Create Account</a></p>

<hr>
<p style="font-size:12px; color:gray;">
Test: Try wrong password 5 times → You will see ⛔ Brute Force Blocked<br>
Test SQLi: `' OR '1'='1` → Will FAIL (blocked)<br>
Test CSRF: Use external form → Will show ❌ Token Invalid
</p>
</body>
</html>

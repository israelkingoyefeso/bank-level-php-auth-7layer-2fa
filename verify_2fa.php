<?php
include 'config.php';

if (!isset($_SESSION['temp_user_id'])) {
    header("Location: secure_login.php");
    exit();
}

// Check if code expired (5 mins)
if (time() - $_SESSION['2fa_time'] > 300) {
    session_destroy();
    die("Code expired! <a href='secure_login.php'>Login again</a>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_code = $_POST['2fa_code'];
    
    if ($user_code == $_SESSION['2fa_code']) {
        // 2FA SUCCESS! Full login now
        session_regenerate_id(true);
        $_SESSION['user_id'] = $_SESSION['temp_user_id'];
        $_SESSION['username'] = $_SESSION['temp_username'];
        
        // Clear temp 2FA data
        unset($_SESSION['temp_user_id'], $_SESSION['2fa_code'], $_SESSION['2fa_time']);
        $_SESSION['login_attempts'] = 0;
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid 2FA code!";
    }
}
?>
<h2>🔐 Two-Factor Authentication</h2>
<p>Hello <b><?php echo htmlspecialchars($_SESSION['temp_username']); ?></b></p>
<p style="background: #ffffcc; padding:10px; border:1px dashed orange;">
  SIMULATION: Your 2FA Code is: <b style="font-size:20px"><?php echo $_SESSION['2fa_code']; ?></b><br>
  <small>(In production, this is sent via Email/SMS)</small>
</p>

<form method="POST">
  Enter 6-digit Code: <input name="2fa_code" required maxlength="6">
  <button>Verify & Login</button>
</form>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<p><a href="secure_login.php">Back to login</a></p>
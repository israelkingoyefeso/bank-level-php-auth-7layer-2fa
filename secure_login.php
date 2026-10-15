<?php
include 'config.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Rate limiting
$ip = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("CSRF Attack Blocked!");
    }

    if ($_SESSION['login_attempts'] >= 3) {
        $wait = 60 - (time() - ($_SESSION['last_attempt'] ?? 0));
        if ($wait > 0) die("Too many attempts! Wait $wait seconds");
        else $_SESSION['login_attempts'] = 0;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // PASSWORD CORRECT - NOW START 2FA!
            $_SESSION['temp_user_id'] = $row['id'];
            $_SESSION['temp_username'] = $username;
            
            // Generate 6-digit code
            $code = rand(100000, 999999);
            $_SESSION['2fa_code'] = $code;
            $_SESSION['2fa_time'] = time();
            
            // In real bank, this is sent via Email/SMS. For your project, we show it.
            // You can say in your documentation: "Code is sent via Email API"
            header("Location: verify_2fa.php");
            exit();
        }
    }
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt'] = time();
    $error = "Invalid username or password!";
}
?>
<form method="POST">
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
  Username: <input name="username" required><br>
  Password: <input type="password" name="password" required><br>
  <button>Login - Step 1</button>
</form>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
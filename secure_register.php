<?php
require 'config.php';
$msg = "";
if (isset($_POST['username'])) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['username'], $hash);
    if ($stmt->execute()) {
        $msg = "<h3 style='color:green'>✅ Registered securely! Hash + Prepared Statement used</h3>";
    } else {
        $msg = "<h3 style='color:red'>❌ Username taken</h3>";
    }
}
?>
<h2>Day 5 - FINAL Secure Register</h2>
<?php echo $msg; ?>
<form method="POST">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
Username: <input name="username" required><br><br>
Password: <input name="password" type="password" required><br><br>
<button>Register Securely</button>
</form>
<a href="secure_login.php">Go to Secure Login</a>
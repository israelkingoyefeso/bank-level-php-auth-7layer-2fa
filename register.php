<?php
$conn = new mysqli("127.0.0.1", "root", "", "secure_lab", 3307);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
if (isset($_POST['username'])) {
    $user = $_POST['username'];
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $hashed);
    $stmt->execute();
    echo "<h3 style='color:green'>✅ Registered! Password is HASHED now</h3>";
}
?>
<h2>Day 4 - Secure Register (Hashing)</h2>
<form method="POST">
Username: <input name="username" required><br><br>
Password: <input name="password" type="password" required><br><br>
<button>Register</button>
</form>
<a href="login_hashed.php">Go to Login</a>
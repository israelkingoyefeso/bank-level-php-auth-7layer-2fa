<?php
$conn = new mysqli("127.0.0.1", "root", "", "secure_lab", 3307);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$msg = "";
if (isset($_POST['username'])) {
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    if ($hash && password_verify($_POST['password'], $hash)) {
        $msg = "<h3 style='color:green'>✅ SUCCESS - Welcome ".$_POST['username']."</h3>";
    } else {
        $msg = "<h3 style='color:red'>❌ FAILED - Invalid</h3>";
    }
}
echo $msg;
?>
<h2>Day 4 - Secure Hashed Login</h2>
<form method="POST">
Username: <input name="username"><br><br>
Password: <input name="password" type="password"><br><br>
<button>Login</button>
</form>
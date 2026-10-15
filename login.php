<?php
// Day 3 Defense - Secure Login by Israel_King

$conn = new mysqli("localhost", "root", "", "my_first_lab", 3307);

if ($conn->connect_error) {
    die("Connection failed");
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username) {
    // SECURE CODE - Prepared Statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2 style='color:green'>✅ Login SUCCESS - Welcome $username</h2>";
    } else {
        echo "<h2 style='color:red'>❌ Login FAILED - Invalid</h2>";
    }
}
?>

<h2>Secure Login - Day 3</h2>
<form method="POST">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="text" name="password"><br><br>
    <button type="submit">Login</button>
</form>
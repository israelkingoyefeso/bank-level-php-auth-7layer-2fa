<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: secure_login.php");
    exit();
}
?>
<h2>🎉 DASHBOARD - Welcome <?php echo $_SESSION['username']; ?>!</h2>
<p style="color:green">✅ You are logged in SECURELY. Session is active.</p>
<p>This page is protected. No one can access without login.</p>
<a href="logout.php">Logout</a>
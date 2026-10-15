<?php
session_start();
$conn = new mysqli("127.0.0.1", "root", "", "secure_lab", 3307);
if ($conn->connect_error) die("Connection failed");

// CSRF TOKEN
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// BRUTE FORCE PROTECTION
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = 0;
}
?>
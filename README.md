> **Live Demo:** Coming Soon | **Certificate ID:** CYBER-2026-1014-IAO

A production-ready secure login system built with raw PHP, implementing 7 security layers and OTP-based Two-Factor Authentication. Not a tutorial project - this blocks real attacks.

**Author:** Israel Adebanji Oyefeso (Abuja, NG)
**GitHub:** github.com/israelkingoyefeso
**LinkedIn:** linkedin.com/in/israelkingoyefeso
**Email:** israelkingoyefeso@gmail.com

### What It Secures (OWASP Top 10)
- SQL Injection - Blocked with Prepared Statements
- XSS Attack - Blocked with htmlspecialchars()
- CSRF Attack - Blocked with Token Validation
- Brute Force - Blocked after 3 tries / 60 sec lockout
- Session Hijacking - Secure flags + regenerate_id
- Weak Passwords - Bcrypt cost 12 (not md5)

### 7-Layer Security
1. Input Validation & Sanitization
2. Prepared Statements (SQLi Protection)
3. Output Encoding (XSS Protection)
4. CSRF Token
5. Secure Session Management
6. Bcrypt Password Hashing
7. Rate Limiting + 2FA OTP

### 2FA Flow
Register -> Login -> OTP 995703 -> Dashboard

### Tech Stack
- PHP 8.x
- MySQL
- Termii SMS API
- Apache / XAMPP
- HTML5 / CSS3

### How to Run
1. Clone: git clone https://github.com/israelkingoyefeso/bank-level-php-auth-7layer-2fa.git
2. Import database.sql to phpMyAdmin
3. Configure db_connect.php
4. Run on localhost

### Tested Payloads - All Blocked
- admin' OR '1'='1 -- SQL Injection
- <script>alert(1)</script> -- XSS
- Multiple failed logins -- Brute Force

### Contact
Open to Junior SOC Analyst / AppSec Roles
Abuja | Lagos | Remote

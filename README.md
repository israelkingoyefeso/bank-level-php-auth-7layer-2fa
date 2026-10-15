> **Live Demo:** Coming Soon | **Certificate ID:** CYBER-2026-1014-IAO

SecureLab - Bank-Level Authentication System in PHP & MySQL

A production-ready secure login system built with raw PHP, implementing 7 security layers and OTP-based Two-Factor Authentication. Not just a tutorial project - this blocks real attacks.

**Author:** Israel Adebanji Oyefeso (Abuja, NG)
**GitHub:** github.com/israelkingoyefeso
**LinkedIn:** linkedin.com/in/israelkingoyefeso
**Email:** israelkingoyefeso@gmail.com

A secure user authentication and management system built with PHP and MySQL, implementing modern security best practices to prevent common web vulnerabilities.

## 🔒 Security Features

- **Two-Factor Authentication (2FA)** - `verify_2fa.php`
- **Secure Password Hashing** - Using `password_hash()` / `password_verify()` - `login_hashed.php`
- **SQL Injection Prevention** - Prepared statements - `secure_login.php`
- **XSS Prevention** - Output sanitization - `secure_comment.php`
- **Session Security** - Protected dashboard access - `dashboard.php`

## 🛠️ Tech Stack

- **Backend:** PHP 8+
- **Database:** MySQL (see `secure_lab.sql`)
- **Frontend:** HTML, CSS
- **Server:** Apache / XAMPP

## 📁 Project Structure

| File | Purpose |
|:--- |:--- |
| `config.php` | Database connection |
| `register.php` | Secure user registration |
| `login.php` | User login |
| `verify_2fa.php` | Two-Factor Authentication |
| `dashboard.php` | Protected user dashboard |
| `secure_lab.sql` | Database schema |
| `login.jpg` | Login page screenshot |

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

### How to Run
1. Clone: git clone https://github.com/israelkingoyefeso/bank-level-php-auth-7layer-2fa.git
2. Import database.sql to phpMyAdmin
3. Configure db_connect.php
4. Run on localhost

### Tested Payloads - All Blocked
- admin' OR '1'='1 -- SQL Injection
- <script>alert(1)</script> -- XSS
- Multiple failed logins -- Brute Force

🎯 What I Learned

Built this lab to understand OWASP Top 10 vulnerabilities and how to defend against them in a real PHP application.

---
*Developed by Israel King Oyefeso* | Cybersecurity / Web Development

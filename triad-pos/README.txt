# TRIAD COFFEE ROASTERS (PHP + MySQL + Staff CRUD)

## ✅ What this ZIP includes
- Login page with **role selection** (Staff / Owner)
- MySQL `users` table (with `is_active` for disabling accounts)
- Secure login using `password_hash()` + `password_verify()`
- Session protection:
  - `staff.php` = Staff POS page
  - `owner.php` = Owner dashboard
  - `owner_staff.php` = **Staff Accounts (CRUD)**: create / edit / enable / disable

## 1) Requirements
- XAMPP / WAMP / Laragon
- PHP 7.4+ (PHP 8+ recommended)
- MySQL / MariaDB

## 2) Install (XAMPP)
1. Extract this folder to:
   `C:\xampp\htdocs\triad-pos`
2. Open XAMPP Control Panel → Start **Apache** and **MySQL**
3. Open phpMyAdmin: `http://localhost/phpmyadmin`
4. Import the database schema:
   - Import file: `database/schema.sql`

## 3) Create sample accounts (RUN ONCE)
Open in browser:
`http://localhost/triad-pos/setup.php`

✅ It will create:
- Owner: `owner@triad.local` / `Owner123!`
- Staff: `staff@triad.local` / `Staff123!`

IMPORTANT: After it works, **DELETE** `setup.php`.

## 4) Login
Go to:
`http://localhost/triad-pos/login.php`

- Staff role → goes to `staff.php`
- Owner role → goes to `owner.php`

## 5) Manage Staff Accounts (CRUD)
Login as Owner, then open:
`http://localhost/triad-pos/owner_staff.php`

You can:
- Create staff accounts
- Edit staff name/email/password
- Disable/Enable staff (disabled staff cannot log in)

## 6) Images
This ZIP already includes your provided images inside `/images/`
and also duplicates in root for the Staff POS page:
- `triad-logo.jpg`
- `triad-mono.jpg`
- `triad-espresso.jpg`
- `triad-darkfruit.jpg`

If you want to replace them, just overwrite those files.

## Notes
- If you see blank images, check that filenames match exactly (Windows sometimes hides extensions).
- If you move the folder name, update your URLs accordingly.

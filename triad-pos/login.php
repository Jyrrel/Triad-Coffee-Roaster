<?php
session_start();
if(isset($_SESSION['user'])){
  $role = $_SESSION['user']['role'];
  header('Location: '.($role==='owner'?'/triad-pos/owner.php':'/triad-pos/staff.php'));
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Triad Coffee Roasters</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body {
    height: 100vh;
    background: url("images/homepage.png") center / cover no-repeat;
    color: #fff;
}


.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    height: 70px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    z-index: 10;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: bold;
}

.logo img {
    height: 38px;
}

.nav-links a,
.login-btn {
    color: #fff;
    text-decoration: none;
    margin-left: 25px;
    font-size: 14px;
}

.login-btn {
    background: #fff;
    color: #000;
    padding: 8px 18px;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
}


.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 20;
}

.role-box,
.login-box {
    width: 380px;
    background: rgba(0,0,0,0.8);
    border-radius: 10px;
    padding: 35px;
}

.role-box {
    text-align: center;
}

.role-box h2 {
    margin-bottom: 20px;
}

.role-box button {
    width: 100%;
    padding: 14px;
    margin-top: 12px;
    border: none;
    border-radius: 4px;
    background: #fff;
    font-weight: bold;
    cursor: pointer;
}

.login-box {
    display: none;
}

.login-box h2 {
    margin-bottom: 6px;
}

.login-box p {
    font-size: 13px;
    opacity: 0.8;
    margin-bottom: 20px;
}

.login-box label {
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
}


.login-box input[type="password"],
.login-box input[type="text"] {
    width: 100%;
    min-width: 100%;   
    max-width: 100%;   
    padding: 12px;
    border: none;
    border-radius: 4px;
    outline: none;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    letter-spacing: normal; 
    margin-bottom: 10px; 
}


.show-password {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    margin-bottom: 20px;
}

.show-password input[type="checkbox"] {
    width: 14px;
    height: 14px;
    flex-shrink: 0; 
    margin: 0;
}

.show-password label {
    margin: 0;
    white-space: nowrap;
}


.login-box input[type="email"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border: none;
    border-radius: 4px;
    outline: none;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
}


.login-box button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 4px;
    background: #fff;
    font-weight: bold;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">
        <img src="images/logo.jpg" alt="Triad Logo">
        <span>Triad Coffee Roasters</span>
    </div>
    <div class="nav-links">
        <a href="#">About Us</a>
        <a href="#">Contact Us</a>
        <span class="login-btn" id="loginBtn">Login</span>
    </div>
</div>

<div class="overlay" id="overlay">

  
    <div class="role-box" id="roleBox">
        <h2>Login As</h2>
        <button data-role="Staff">Staff</button>
        <button data-role="Owner">Owner</button>
    </div>

  
    <div class="login-box" id="loginBox">
        <h2 id="roleTitle"></h2>
        <p>Sign in to your account</p>

        <label>Email</label>
        <input type="email" id="email" placeholder="you@example.com" required>

        <label>Password</label>
        <input type="password" id="password" required>

        <div class="show-password">
            <input type="checkbox" id="togglePassword">
            <label for="togglePassword">Show password</label>
        </div>

        <button id="signInBtn">Sign In</button>

    </div>

</div>


<script src="assets/js/login.js" defer></script>
</body>
</html>

<?php
include 'session.php';
include 'db.php';

$error = '';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if($email && $password){
        $stmt = $pdo->prepare("SELECT id, full_name, password_hash FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            if(password_verify($password, $user['password_hash'])){
                $_SESSION['user'] = $user['full_name'];
                $_SESSION['email'] = $email;
                header("Location: store.php");
                exit;
            } else $error = "Incorrect password!";
        } else $error = "Email not registered!";
    } else $error = "Enter email and password!";
}

if(isset($_POST['register'])){
    $name     = trim($_POST['name']);
    $surname  = trim($_POST['surname']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    if(!$name || !$surname || !$email || !$phone || !$password || !$confirm){
        $error = "All fields are required!";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email!";
    } elseif(!preg_match("/^[0-9]{10}$/", $phone)){
        $error = "Phone must be 10 digits!";
    } elseif($password !== $confirm){
        $error = "Passwords do not match!";
    } else {
        // Check if email exists
        $check = $pdo->prepare("SELECT email FROM users WHERE email=? LIMIT 1");
        $check->execute([$email]);
        if($check->rowCount() > 0){
            $error = "Email already registered!";
        } else {
            $fullName = $name . " " . $surname;
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
            if($insert->execute([$fullName, $email, $phone, $hash])){
                $_SESSION['user'] = $fullName;
                $_SESSION['email'] = $email;
                header("Location: store.php");
                exit;
            } else $error = "Registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KYT Helmet Shop - Login/Register</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
body, html {
    margin: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    -webkit-text-fill-color: white;
}

/* Fullscreen background image */
body {
    background-image: url('static/images/home-slider-2.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: flex-start; /* align form to top-left */
}

/* Form card on left */
.form-container {
    margin: 40px;
    background-color: black; /* slight transparency */
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 420px;
}

/* Inputs */
input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    outline: none;
    font-size: 14px;
    margin-bottom: 12px;
    transition: border-color 0.3s, box-shadow 0.3s;
    -webkit-text-fill-color: black;
    display: block;
    padding-bottom: 20px;
}

input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
}

/* Buttons */
button {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    font-weight: bold;
    transition: transform 0.2s, background-color 0.3s;
    margin-top: 8px;
}

button:hover {
    transform: scale(1.02);
}

/* Login / Register buttons */
.login-btn {
    background-color: #6366f1;
    color: white;
}

.login-btn:hover { background-color: #4f46e5; }

.register-btn {
    background-color: #10b981;
    color: white;
}

.register-btn:hover { background-color: #059669; }

/* Toggle text */
.toggle-text {
    font-size: 14px;
    margin-top: 10px;
}
.toggle-text button {
    font-weight: bold;
}
</style>
</head>
<body>
<div class="form-container">
    <h2 class="text-2xl font-bold mb-4">KYT Helmet Shop</h2>
    <?php if($error) echo "<p class='text-red-400 mb-2'>$error</p>"; ?>

    <!-- Login Form -->
    <form method="POST" id="login-form" class="space-y-3 slide-in-up">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="login-btn" name="login">Login</button>
        <p class="toggle-text">Don't have an account? <button type="button" id="show-register" class="underline text-indigo-400">Register</button></p>
    </form>

    <!-- Register Form -->
    <form method="POST" id="register-form" class="space-y-3 hidden">
        <input type="text" name="name" placeholder="First Name" required>
        <input type="text" name="surname" placeholder="Surname" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone (10 digits)" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button class="register-btn" name="register">Register</button>
        <p class="toggle-text">Already have an account? <button type="button" id="show-login" class="underline text-green-300">Login</button></p>
    </form>
</div>

<script>
document.getElementById('show-register').onclick = ()=>{document.getElementById('login-form').classList.add('hidden');document.getElementById('register-form').classList.remove('hidden');};
document.getElementById('show-login').onclick = ()=>{document.getElementById('register-form').classList.add('hidden');document.getElementById('login-form').classList.remove('hidden');};
</script>
</body>
</html>

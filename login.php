<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.html');
    exit;
}

$valid_users = [
    'johndoe@gmail.com' => 'password123'
];

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['logout'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address';
    } elseif (isset($valid_users[$email]) && $valid_users[$email] === $password) {
        // Login successful
        $_SESSION['user_email'] = $email;
        $_SESSION['logged_in'] = true;
        $success_message = 'Login successful!';
    } else {
        $error_message = 'Invalid email or password';
    }
}

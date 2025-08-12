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

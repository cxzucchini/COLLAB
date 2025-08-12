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

$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_logged_in ? 'Dashboard' : 'Login'; ?></title>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
            background-color: #fafafa;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #20b2aa;
            background-color: white;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            background-color: #20b2aa;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #1a9b94;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .error-message {
            color: #e74c3c;
            background-color: #fdf2f2;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .success-message {
            color: #27ae60;
            background-color: #f2fdf2;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c6f5cb;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .user-info h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .user-info p {
            margin-bottom: 8px;
            color: #666;
        }

        .back-link {
            display: inline-block;
            color: #20b2aa;
            text-decoration: none;
            margin-top: 15px;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($is_logged_in): ?>
            <!-- Dashboard View -->
            <div class="dashboard-header">
                <h1>Dashboard</h1>
                <form method="POST" style="margin: 0;">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
            
            <div class="user-info">
                <h3>Welcome back!</h3>
                <p>You have successfully logged in to your account.</p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                <p><strong>Status:</strong> Logged In</p>
                <p><strong>Session Active:</strong> Yes</p>
            </div>
            
        <?php else: ?>
            <!-- Login View -->
            <h1>Log in</h1>
            
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
                <script>
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                </script>
<?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="jamest@gmail.com" 
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'johndoe@gmail.com'; ?>"
                    >
                </div>
                
                <div class="form-group">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Password" 
                        required
                    >
                </div>
                
                <button type="submit" class="login-btn">Log in</button>
            </form>
            
            <a href="index.html" class="back-link">← Back to static version</a>
        <?php endif; ?>
    </div>
</body>
</html>

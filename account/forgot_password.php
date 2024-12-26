<?php
session_start();
require_once '../classes/database.class.php';

$forgotPasswordError = '';
$forgotPasswordSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    // Basic validation
    if (empty($username)) {
        $forgotPasswordError = "Please enter your username.";
    } else {
        // Check if the username exists
        $db = new Database();
        $conn = $db->connect();
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate a password reset token
            $resetToken = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry time (1 hour)
            $sql = "UPDATE users SET reset_token = :reset_token, reset_token_expiry = :expiry WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':reset_token', $resetToken);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->bindParam(':username', $username);
            if ($stmt->execute()) {
                $resetLink = "http://localhost/reset_password.php?token=$resetToken";
                mail($user['email'], "Password Reset Request", "Click the link to reset your password: $resetLink");
                $forgotPasswordSuccess = "A password reset link has been sent to your email address.";
            } else {
                $forgotPasswordError = "Error generating reset link. Please try again.";
            }
        } else {
            $forgotPasswordError = "Username not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/css/bootstrap.min.css">
    <style>
        <?php require_once '../vendor/bootstrap-5.3.3/css/bootstrap.min.css'?>
        <?php require_once '../css/login.css'?>
    </style>
</head>
<body>
    <section id="logBg" class="bg-image">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
                <div class="text-center">
                    <h2 class="mb-4">Forgot Password</h2>
                </div>
                <?php if ($forgotPasswordError): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($forgotPasswordError) ?>
                    </div>
                <?php endif; ?>
                <?php if ($forgotPasswordSuccess): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($forgotPasswordSuccess) ?>
                    </div>
                <?php endif; ?>
                <form action="forgot_password.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>
                <div class="text-center mt-3">
                    <p><a href="../account/login.php" class="text-decoration-none">Back to Login</a></p>
                </div>
            </div>
        </div>
    </section>
    
    <script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

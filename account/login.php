<?php
session_start();
require_once '../classes/database.class.php';

// Check if user is already logged in, if so, redirect to dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: ../admin/dashboard.php');
    exit;
}

// Initialize variables
$username = $Password = '';
$loginError = '';
// Process the login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $Password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    // Basic validation
    if (empty($username) || empty($Password)) {
        $loginError = "Please enter both username and Password.";
    } else {
        // Check user credentials in the database
        $db = new Database();
        $conn = $db->connect();
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($Password, $user['Password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['student_id'] = $user['student_id'];

            header('Location: ../admin/dashboard.php'); // Redirect to dashboard after successful login
            exit;
        } else {
            // Invalid credentials
            $loginError = "Invalid username or Password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Appraisal</title>
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
                    <img src="../img/image-removebg-preview 1.png" alt="Logo" class="img-fluid mb-3" style="max-width: 150px;">
                    <h2 class="mb-4">Student Appraisal</h2>
                </div>
                <?php if ($loginError): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($loginError) ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" value="<?= htmlspecialchars($username) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="Password" name="Password" id="Password" class="form-control" placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="../account/signup.php" class="text-decoration-none">Sign Up</a></p>
                    <p><a href="forgot_password.php" class="text-decoration-none">Forgot your password?</a></p>
                </div>
            </div>
        </div>
    </section>
    <script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

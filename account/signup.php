<?php
session_start();
require_once '../classes/database.class.php';

$signupError = '';
$signupSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($username) || empty($student_id) || empty($password) || empty($confirmPassword)) {
        $signupError = "Please fill all fields.";
    } elseif ($password !== $confirmPassword) {
        $signupError = "Passwords do not match.";
    } else {
        // Check if student ID exists in the database
        $db = new Database();
        $conn = $db->connect();
        
        $sql = "SELECT COUNT(*) FROM students WHERE student_id = :student_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        if ($stmt->fetchColumn() == 0) {
            $signupError = "Student ID is not recognized.";
        } else {
            // Check if username already exists
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                $signupError = "Username already exists.";
            } else {
                // Insert new user into the database
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, student_id, password) VALUES (:username, :student_id, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':student_id', $student_id);
                $stmt->bindParam(':password', $hashPassword);

                if ($stmt->execute()) {
                    $signupSuccess = "Registration successful! You can now log in.";
                } else {
                    $signupError = "Error during registration. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        <?php require_once '../vendor/bootstrap-5.3.3/css/bootstrap.min.css'?>
        <?php require_once '../css/login.css'?>
    </style>
</head>
<body>
    <section id="logBg" class="bg-image">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
                <div class="text-center">
                    <h2 class="mb-4">Create an Account</h2>
                </div>
                <?php if ($signupError): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($signupError) ?>
                    </div>
                <?php endif; ?>
                <?php if ($signupSuccess): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($signupSuccess) ?>
                    </div>
                <?php endif; ?>
                <form action="../account/signup.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" name="student_id" id="student_id" class="form-control" placeholder="Enter your Student ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="../account/login.php" class="text-decoration-none">Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        <?php require_once '../css/dashboard.css'?>
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <div class="logo">
                    <img src="../landingpage/Group 16.png" alt="Logo">
                </div>
                <h2>Student Appraisal</h2>
            </div>
            <nav>
                <ul>
                <li><a href="../admin/dashboard.php" class="active"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="../admin/enrollmentstatus.php"><i class="fas fa-user-check"></i> Enrollment Status</a></li>
                    <li><a href="../admin/curriculum.php"><i class="fas fa-book"></i> Curriculum</a></li>
                    <li><a href="../admin/enrollments.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
            <a href="../account/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </aside>
    </div>
</body>
</html>
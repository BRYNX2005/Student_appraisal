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
        <main>
            <div class="profile">
                <div class="profile-card">
                    <div class="profile-icon">
                        <img src="../img/iconamoon_profile-circle-fill.png" alt="Profile">
                    </div>
                    <div class="profile-details">
                        <h2><?= htmlspecialchars($_SESSION['username']) ?></h2>
                        <p>Program: BS Computer Science</p>
                        <p>Student ID: 2023-01319</p>
                        <button>Full Profile</button>
                    </div>
                </div>
                <div class="forms-container">
                    <div class="forms">
                        <button>Payments</button>
                        <button>View Grades</button>
                        <button>Attendance</button>
                        <button>View COR</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
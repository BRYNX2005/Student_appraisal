<?php
session_start();
require '../classes/database.class.php';

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'student'; 
}
$userRole = $_SESSION['role'];

try {
    $db = new Database;
    $conn = $db->connect();
    $sql = "SELECT * FROM students";

    if (isset($_GET['course']) && !empty($_GET['course'])) {
        $sql .= " WHERE course = :course";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course', $_GET['course'], PDO::PARAM_STR);
    } else {
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching students: " . $e->getMessage();
    $students = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO students (Full_name, Age, School_year, Course, Student_ID) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['fullname'], 
                $_POST['age'], 
                $_POST['school_year'], 
                $_POST['course'], 
                $_POST['student_id']
            ]);
            echo "<script>alert('Student Added Successfully')</script>";
        } elseif ($action === 'edit') {
            $stmt = $conn->prepare("UPDATE students SET Full_name = ?, Age = ?, School_year = ?, Course = ? WHERE Student_ID = ?");
            $stmt->execute([
                $_POST['fullname'], 
                $_POST['age'], 
                $_POST['school_year'], 
                $_POST['course'], 
                $_POST['student_id']
            ]);
            echo "<script>alert('Student Updated Successfully')</script>";
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM students WHERE Student_ID = ?");
            $stmt->execute([$_POST['student_id']]);
            echo "<script>alert('Student Deleted Successfully')</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Role-Based Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php require_once '../css/dashboard.css'; ?>
    </style>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">
            <img src="../landingpage/Group 16.png" alt="Logo">
            <h2>Student Appraisal</h2>
        </div>
        <nav>
            <ul>
                <li><a href="../admin/dashboard.php" class="active"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="../admin/enrollmentstatus.php"><i class="fas fa-user-check"></i> Enrollment Status</a></li>
                <li><a href="../admin/curriculum.php"><i class="fas fa-book"></i> Curriculum</a></li>
                <li><a href="../admin/grades.php"><i class="fas fa-book"></i> Grades</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>
        <a href="../account/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List of Enrolled Students Under BSCS</h4>
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="resetForm('add')">
                                Add Student
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>School Year</th>
                                    <th>Course</th>
                                    <th>Student ID</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $id = 0;
                                if (!empty($students)) {
                                    foreach ($students as $student) {
                                        $id++;
                                        echo "<tr>";
                                        echo "<td>{$id}</td>";
                                        echo "<td>{$student['Full_name']}</td>";
                                        echo "<td>{$student['Age']}</td>";
                                        echo "<td>{$student['School_year']}</td>";
                                        echo "<td>{$student['Course']}</td>";
                                        echo "<td>{$student['Student_ID']}</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#studentModal' onclick='populateForm(" . json_encode($student) . ")'>Edit</button> ";
                                        echo "<form method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>";
                                        echo "<input type='hidden' name='action' value='delete'>";
                                        echo "<input type='hidden' name='student_id' value='{$student['Student_ID']}'>";
                                        echo "<button class='btn btn-danger btn-sm'>Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No students found.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="studentModalLabel">Add/Edit Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" id="action" value="add">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fullname">Full Name</label>
                            <input type="text" name="fullname" id="fullname" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="age">Age</label>
                            <input type="number" name="age" id="age" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="school_year">School Year</label>
                            <input type="text" name="school_year" id="school_year" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="course">Course</label>
                            <input type="text" name="course" id="course" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="student_id">Student ID</label>
                            <input type="text" name="student_id" id="student_id" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function resetForm(action) {
        document.getElementById('action').value = action;
        document.getElementById('fullname').value = '';
        document.getElementById('age').value = '';
        document.getElementById('school_year').value = '';
        document.getElementById('course').value = '';
        document.getElementById('student_id').value = '';
    }

    function populateForm(student) {
        document.getElementById('action').value = 'edit';
        document.getElementById('fullname').value = student.Full_name;
        document.getElementById('age').value = student.Age;
        document.getElementById('school_year').value = student.School_year;
        document.getElementById('course').value = student.Course;
        document.getElementById('student_id').value = student.Student_ID;
    }
    
</script>
</body>
</html>

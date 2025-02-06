<?php
include('../includes/config.php');
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

$employee_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='employee'")->fetch_assoc();
$present_count = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date=CURDATE() AND status='present'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <p>Total Employees: <?= $employee_count['total'] ?></p>
    <p>Present Today: <?= $present_count['total'] ?></p>
    <a href="manage_users.php">Manage Employees</a> |
    <a href="attendance.php">View Attendance</a> |
    <a href="reports.php">Generate Reports</a> |
    <a href="logout.php">Logout</a>
</body>
</html>

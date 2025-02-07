<?php
session_start(); // Ensure session starts before any output

include('../includes/config.php');
include('../includes/header.php');

// Check if the session variable is set
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../index.php');
    exit;
}

// Check if 'name' is set, else provide a default value
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

?>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Welcome, <?= htmlspecialchars($name); ?>!</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4 text-center">
            <a href="profile.php" class="btn btn-primary btn-lg w-100 mb-3">View Profile</a>
        </div>
        <div class="col-md-4 text-center">
            <a href="leave.php" class="btn btn-success btn-lg w-100 mb-3">Apply for Leave</a>
        </div>
        <div class="col-md-4 text-center">
            <form method="POST" action="mark_attendance.php">
                <button type="submit" name="mark_attendance" class="btn btn-warning btn-lg w-100">Mark Attendance</button>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

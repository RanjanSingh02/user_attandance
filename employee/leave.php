<?php
include('../includes/config.php');
include('../includes/header.php');
session_start();

if ($_SESSION['role'] !== 'employee') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("
        INSERT INTO leaves (user_id, leave_type, start_date, end_date, reason) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param('issss', $user_id, $leave_type, $start_date, $end_date, $reason);
    $stmt->execute();

    $message = "Leave request submitted successfully!";
}
?>
<!-- Ranjan -->
<div class="container">
    <h1>Apply for Leave</h1>
    <?php if (isset($message)) echo "<p class='alert alert-success'>$message</p>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="leave_type">Leave Type</label>
            <select name="leave_type" id="leave_type" class="form-control" required>
                <option value="sick">Sick Leave</option>
                <option value="casual">Casual Leave</option>
                <option value="earned">Earned Leave</option>
                <option value="unpaid">Unpaid Leave</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="reason">Reason</label>
            <textarea name="reason" id="reason" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

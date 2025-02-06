<?php
include('../includes/config.php');
session_start();
if ($_SESSION['role'] != 'employee') {
    header('Location: ../index.php');
    exit;
}

$user_id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'clock_in') {
        $conn->query("INSERT INTO attendance (user_id, date, clock_in, status) VALUES ('$user_id', CURDATE(), CURTIME(), 'present')");
    } elseif ($type === 'clock_out') {
        $conn->query("UPDATE attendance SET clock_out=CURTIME() WHERE user_id='$user_id' AND date=CURDATE()");
    }
}

$result = $conn->query("SELECT * FROM attendance WHERE user_id='$user_id' AND date=CURDATE()");
$attendance = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
</head>
<body>
    <h1>Attendance</h1>
    <?php if ($attendance): ?>
        <p>Clock-In: <?= $attendance['clock_in'] ?></p>
        <p>Clock-Out: <?= $attendance['clock_out'] ?? 'Not yet' ?></p>
    <?php else: ?>
        <form method="POST">
            <button type="submit" name="type" value="clock_in">Clock-In</button>
        </form>
    <?php endif; ?>
    <?php if ($attendance && !$attendance['clock_out']): ?>
        <form method="POST">
            <button type="submit" name="type" value="clock_out">Clock-Out</button>
        </form>
    <?php endif; ?>
</body>
</html>

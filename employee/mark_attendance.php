<?php
include('../includes/config.php');
session_start();

// Check if the user is logged in and has the correct role
if ($_SESSION['role'] != 'employee') {
    header('Location: ../index.php');
    exit;
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'type' field is set in the POST request
    if (isset($_POST['type'])) {
        $type = $_POST['type'];

        if ($type === 'clock_in') {
            // Insert the clock-in record into the attendance table
            $conn->query("INSERT INTO attendance (user_id, date, clock_in, status) VALUES ('$user_id', CURDATE(), CURTIME(), 'present')");
        } elseif ($type === 'clock_out') {
            // Update the clock-out time in the attendance table
            $conn->query("UPDATE attendance SET clock_out=CURTIME() WHERE user_id='$user_id' AND date=CURDATE()");
        }
    }
}

// Fetch the attendance record for the current user and date
$result = $conn->query("SELECT * FROM attendance WHERE user_id='$user_id' AND date=CURDATE()");
$attendance = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Attendance</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($attendance): ?>
                            <div class="mb-4">
                                <p><strong>Log IN:</strong> <?= htmlspecialchars($attendance['clock_in']) ?></p>
                                <p><strong>Log OUT:</strong> <?= htmlspecialchars($attendance['clock_out'] ?? 'Not yet') ?></p>
                            </div>
                        <?php else: ?>
                            <div class="text-center mb-4">
                                <form method="POST">
                                    <button type="submit" name="type" value="clock_in" class="btn btn-success btn-lg">Clock-In</button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php if ($attendance && !$attendance['clock_out']): ?>
                            <div class="text-center mb-4">
                                <form method="POST">
                                    <button type="submit" name="type" value="clock_out" class="btn btn-warning btn-lg">Clock-Out</button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <!-- Back to Dashboard button -->
                        <div class="text-center">
                            <form method="get" action="dashboard.php">
                                <button type="submit" class="btn btn-info btn-lg">Back to Dashboard</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include('../includes/config.php');
include('../includes/header.php');

// Check if user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../index.php');
    exit;
}

// Fetch user data
$user_id = $_SESSION['id'];
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Employee Profile</h3>
                </div>
                <div class="card-body">
                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <img src="../assets/images/logo.png" alt="Profile Picture" class="img-fluid rounded-circle" width="150">
                    </div>
                    
                    <!-- Profile Details Table -->
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td><?= htmlspecialchars($user['name'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user['email'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= htmlspecialchars($user['phone'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?= htmlspecialchars($user['department'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td><?= htmlspecialchars($user['designation'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Joining Date</th>
                            <td><?= htmlspecialchars($user['joining_date'] ?? 'Not Available'); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?= htmlspecialchars($user['address'] ?? 'Not Available'); ?></td>
                        </tr>
                    </table>

                    <!-- Edit Profile Button -->
                    <div class="text-center mt-3">
                        <a href="update_profile.php" class="btn btn-warning btn-lg">Edit Profile</a>
                    </div>

                    <!-- Dashboard Button -->
                    <div class="text-center mt-3">
                        <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

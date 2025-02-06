<?php
include('../includes/config.php');
include('../includes/header.php');
session_start();

if ($_SESSION['role'] !== 'employee') {
    header('Location: ../index.php');
    exit;
}

// Fetch employee data
$user_id = $_SESSION['id'];
$query = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
$employee = $result->fetch_assoc();
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Employee Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="../assets/default_profile.png" alt="Profile Picture" class="img-thumbnail" width="150">
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td><?= htmlspecialchars($employee['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($employee['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= htmlspecialchars($employee['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?= htmlspecialchars($employee['department']); ?></td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td><?= htmlspecialchars($employee['designation']); ?></td>
                        </tr>
                        <tr>
                            <th>Joining Date</th>
                            <td><?= htmlspecialchars($employee['joining_date']); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?= htmlspecialchars($employee['address']); ?></td>
                        </tr>
                    </table>
                    <div class="text-center">
                        <a href="update_profile.php" class="btn btn-success">Update Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

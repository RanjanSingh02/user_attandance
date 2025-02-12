<?php
session_start();
include('../includes/config.php');
include('../includes/header.php');

// Check if user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../index.php');
    exit;
}

$user_id = $_SESSION['id'];

// Fetch user profile data
$query = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $joining_date = isset($_POST['joining_date']) ? $_POST['joining_date'] : ''; // Fix undefined array key
    $address = isset($_POST['address']) ? $_POST['address'] : ''; // Fix undefined array key

    // Profile Picture Upload
    $upload_dir = __DIR__ . "/../assets/images/"; // Corrected Path

// Ensure the folder exists
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create folder if not exists
}

// Process Profile Picture Upload
if (!empty($_FILES['profile_pic']['name'])) {
    $profile_pic = time() . '_' . basename($_FILES['profile_pic']['name']);
    $profile_pic_path = $upload_dir . $profile_pic;

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path)) {
        // File uploaded successfully
    } else {
        echo "<div class='alert alert-danger'>File upload failed. Check folder permissions.</div>";
    }
} else {
    $profile_pic = $user['profile_pic'];
}


    // Update User Profile
    $stmt = $conn->prepare("UPDATE user_profiles SET phone=?, department=?, designation=?, joining_date=?, address=?, profile_pic=? WHERE user_id=?");
    $stmt->bind_param("ssssssi", $phone, $department, $designation, $joining_date, $address, $profile_pic, $user_id);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating profile.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white text-center">
                    <h3>Edit Profile</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? ''); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Department</label>
                            <input type="text" name="department" value="<?= htmlspecialchars($user['department'] ?? ''); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Designation</label>
                            <input type="text" name="designation" value="<?= htmlspecialchars($user['designation'] ?? ''); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Joining Date</label>
                            <input type="date" name="joining_date" value="<?= htmlspecialchars($user['joining_date'] ?? ''); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?= htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

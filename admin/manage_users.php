<?php
include('../includes/config.php');
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = 'employee';
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
}

$employees = $conn->query("SELECT * FROM users WHERE role='employee'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Employees</title>
</head>
<body>
    <h1>Manage Employees</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Add Employee</button>
    </form>
    <h2>Employee List</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $employees->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

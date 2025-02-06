<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: employee/dashboard.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/config.php');
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: employee/dashboard.php');
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS Link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles for attractive UI */
        body {
            background: linear-gradient(135deg, #6e7aeb, #3b8d99);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Roboto', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background-color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .logo {
            max-width: 80%;
            height: auto;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
            background-color: #ff6b6b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff4757;
        }

        .container {
            margin-top: 100px;
        }

        .welcome-banner {
            text-align: center;
            font-size: 3rem;
            color: #ffffff;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 25px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }

        .card-title {
            color: #333;
            font-weight: bold;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="welcome-banner">
        <h1>WELCOME TO THINKBOA</h1>
    </div>

    <div class="container d-flex justify-content-center align-items-center" style="height: 70vh;">
        <div class="card" style="max-width: 400px; width: 100%;">
            <div class="card-header">
                <img src="assets/images/logo.png" alt="Logo" class="logo"> <!-- Replace with your logo -->
            </div>
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Login</h5>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

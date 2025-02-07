<?php
include('../includes/config.php');
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

$employee_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='employee'")->fetch_assoc();
$present_count = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date=CURDATE() AND status='present'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS Link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 60px; /* Ensures content doesn't overlap footer */
        }

        .navbar {
            background-color: #007bff;
            height: 60px; /* Consistent height */
        }

        .navbar a {
            color: #ffffff;
        }

        .navbar a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .card-body {
            font-size: 1.5rem;
        }

        /* Footer fixed at the bottom */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 15px;
            background-color: #343a40;
            color: #ffffff;
            font-size: 14px;
        }

        .container {
            margin-top: 60px;
        }

        h1 {
            font-size: 2.5rem;
            color: #007bff;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Mobile View Adjustments */
        @media (max-width: 767px) {
            h1 {
                font-size: 2rem;
            }

            .navbar {
                font-size: 1rem;
            }

            .card {
                margin-bottom: 20px;
            }

            .footer {
                font-size: 12px;
                padding: 15px;
            }

            .card-body {
                font-size: 1.2rem;
            }

            /* Mobile Menu - Card Style for Visibility */
            .navbar-nav {
                width: 100%;
                padding: 0;
                text-align: center;
            }

            .navbar-nav .nav-item {
                width: 100%;
            }

            .navbar-nav .nav-link {
                color: #000 !important; /* Black text for menu */
                padding: 15px 0;
                display: block;
            }

            .navbar-nav .nav-link:hover {
                background-color: #ddd;
                color: #000 !important;
            }

            /* Card style for the mobile menu */
            .navbar-collapse {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">ThinkBOA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">Manage Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="attendance.php">View Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Generate Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome, Admin</h1>

        <!-- Statistics Cards -->
        <div class="row justify-content-center">
            <!-- Total Employees -->
            <div class="col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Total Employees
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?= $employee_count['total'] ?></h3>
                    </div>
                </div>
            </div>

            <!-- Present Today -->
            <div class="col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        Present Today
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?= $present_count['total'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 ThinkBOA. All rights reserved.</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Full jQuery version -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // This ensures the mobile menu works correctly
        $(document).ready(function() {
            // Ensure the collapse toggles the menu correctly
            $('.navbar-toggler').click(function() {
                $('#navbarNav').collapse('toggle');
            });
        });
    </script>
</body>
</html>

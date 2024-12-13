<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}
?>

<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villa_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk menghitung total villas
$sql_total_villas = "SELECT COUNT(*) as total FROM villas";
$result_villas = $conn->query($sql_total_villas);
$total_villas = $result_villas->fetch_assoc()['total'];

$sql_total_booking = "SELECT COUNT(*) as total FROM booking";
$result_booking = $conn->query($sql_total_booking);
$total_booking = $result_booking->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillaStay - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #f8f9fe;
            --sidebar-width: 250px;
            --header-height: 70px;
            --primary-color: #5e72e4;
            --secondary-color: #525f7f;
        }

        body {
            background-color: var(--primary-bg);
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(87deg, #172b4d, #1a174d);
            padding-top: var(--header-height);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .header {
            height: var(--header-height);
            background: #fff;
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 999;
            padding: 0 25px;
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        }

        .navbar-brand {
            color: #fff;
            font-size: 1.5rem;
            padding: 1.5rem 1.5rem;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: var(--header-height);
            background: rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            z-index: 1001;
        }

        .nav-link {
            color: rgba(255,255,255,.85) !important;
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
            border-radius: 0.375rem;
            margin: 0.2rem 1rem;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.1);
            color: #fff !important;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: #fff !important;
            box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08);
        }

        .nav-link i {
            width: 1.25rem;
            margin-right: 1rem;
            font-size: 0.9rem;
        }

        .card {
            background: #fff;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
            transition: all 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .2);
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 1rem;
            background: #fff;
        }

        .stat-card .icon {
            padding: 12px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
        }

        .search-bar {
            background: rgba(255, 255, 255, .1);
            border: none;
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            width: 100%;
            margin: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #fff;
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            padding: 1rem;
        }

        .badge {
            padding: 0.5em 0.75em;
        }

        .btn-action {
            padding: 0.5rem;
            line-height: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="navbar-brand">
            <i class="fas fa-hotel me-2"></i>
            <span>VillaStay</span>
        </div>

        <input type="text" class="search-bar" placeholder="Search...">

    
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="villas.php">
                    <i class="fas fa-building"></i>
                    <span>Villas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="bookings.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
         <!-- Logout -->
         <li class="nav-item mt-auto">
            <a class="btn btn-danger btn-sm w-100 text-center" href="../logout.php">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </li>
    </ul>
</aside>

        <div class="user-profile mt-auto">
            <img src="/api/placeholder/32/32" class="rounded-circle me-2" alt="Profile">
            <div>
                <small class="d-block text-muted">Welcome back,</small>
                <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            </div>
        </div>
    </aside>

    <!-- Header -->
    <header class="header d-flex align-items-center">
        <button class="btn btn-link text-secondary me-3 p-0">
            <i class="fas fa-bars"></i>
        </button>
        <div class="d-flex align-items-center ms-auto">
            <div class="dropdown me-3">
                <button class="btn btn-link text-secondary p-0 position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">New Booking</a>
                    <a class="dropdown-item" href="#">Payment Received</a>
                    <a class="dropdown-item" href="#">System Update</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-link text-secondary p-0" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item" href="settings.php">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->   
            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <!-- Total Bookings -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 text-muted">Total Bookings</h6>
                                    <h3 class="mb-0"><?= $total_booking; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Active Villas -->
<div class="col-12 col-sm-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-building"></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-1 text-muted">Active Villas</h6>
                    <h3 class="mb-0"><?= $total_villas; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Recent Activity & Tasks -->
            <div class="row g-4">
                <!-- Recent Activity -->
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Bookings</h5>
                                <a href="#" class="btn btn-sm btn-link">View All</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Villa Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_villas = "SELECT nama_villa, harga_per_malam, status FROM villas LIMIT 5";
                $result_villas_list = $conn->query($sql_villas);

                if ($result_villas_list->num_rows > 0) {
                    while ($villa = $result_villas_list->fetch_assoc()) {
                        echo "<tr>
                            <td>{$villa['nama_villa']}</td>
                            <td>Rp " . number_format($villa['harga_per_malam'], 0, ',', '.') . "</td>
                            <td><span class='badge " . ($villa['status'] == 'available' ? 'bg-success' : 'bg-danger') . "'>" . ucfirst($villa['status']) . "</span></td>
                            <td><a href='villas.php' class='btn btn-primary btn-sm'>Manage</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>No Villas Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

             
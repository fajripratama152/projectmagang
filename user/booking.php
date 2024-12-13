<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villa_db";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil detail villa berdasarkan ID
if (isset($_GET['villa_id'])) {
    $villa_id = $_GET['villa_id'];
    $query = $conn->query("SELECT * FROM villas WHERE id_villa = $villa_id");
    $villa = $query->fetch_assoc();
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_user = $_POST['nama_user']; // Ambil nama user dari form
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $villa_id = $_POST['villa_id'];
    $total_harga = $_POST['total_harga'];
    $status = 'Pending';

    // Simpan data ke tabel booking
    $stmt = $conn->prepare("INSERT INTO booking (nama_user, villa_id, check_in, check_out, total_harga, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissis", $nama_user, $villa_id, $check_in, $check_out, $total_harga, $status);

    if ($stmt->execute()) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://source.unsplash.com/1920x1080/?luxury,beach') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .booking-card {
            position: relative;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-label {
            font-weight: bold;
            color: #555;
        }
        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
    </style>
</head>
<body>
<div class="booking-card">
    <h1>Booking <?= htmlspecialchars($villa['nama_villa']) ?></h1>
    <form method="POST">
        <input type="hidden" name="villa_id" value="<?= $villa['id_villa'] ?>">

        <!-- Nama User -->
        <div class="mb-3">
            <label for="nama_user" class="form-label">Nama User</label>
            <input type="text" id="nama_user" name="nama_user" class="form-control" required>
        </div>

        <!-- Tanggal Check-In -->
        <div class="mb-3">
            <label for="check_in" class="form-label">Tanggal Check-In</label>
            <input type="date" id="check_in" name="check_in" class="form-control" required>
        </div>

        <!-- Tanggal Check-Out -->
        <div class="mb-3">
            <label for="check_out" class="form-label">Tanggal Check-Out</label>
            <input type="date" id="check_out" name="check_out" class="form-control" required>
        </div>

        <!-- Total Harga -->
        <div class="mb-3">
            <label for="total_harga" class="form-label">Total Harga</label>
            <input type="text" id="total_harga" name="total_harga" class="form-control"
                   value="<?= $villa['harga_per_malam'] ?>" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100">Konfirmasi Booking</button>
    </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

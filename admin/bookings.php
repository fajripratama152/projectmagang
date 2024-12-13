<?php
// Mulai session
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'villa_db');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses hapus data jika parameter 'id' ada
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengamankan input ID
    $query = "DELETE FROM booking WHERE id_booking = $id";
    
    if ($conn->query($query)) {
        header("Location: bookings.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Query untuk mendapatkan data booking dengan join ke tabel villas
$query = "SELECT booking.id_booking, booking.check_in, booking.check_out, booking.total_harga, booking.status, booking.nama_user, villas.nama_villa 
          FROM booking 
          JOIN villas ON booking.villa_id = villas.id_villa";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="../admin/index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h4 class="mb-0">Data Booking</h4>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Booking</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Booking</th>
                                <th>Nama Villa</th>
                                <th>Nama User</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id_booking']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_villa']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_user']) ?></td>
                                        <td><?= htmlspecialchars($row['check_in']) ?></td>
                                        <td><?= htmlspecialchars($row['check_out']) ?></td>
                                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>
                                            <a href="bookings.php?id=<?= $row['id_booking'] ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                               <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data booking.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

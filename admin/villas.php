<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "villa_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus data jika diminta
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = $conn->prepare("DELETE FROM villas WHERE id_villa = ?");
    $delete_query->bind_param("i", $delete_id);
    $delete_query->execute();
    header("Location: villas.php");
    exit();
}

// Mendapatkan data villas
$result = $conn->query("SELECT * FROM villas");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillaStay - Daftar Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #4a6cf7;
            --secondary-color: #8a94ad;
            --bg-color: #f4f7ff;
            --white: #ffffff;
            --black: #0e1422;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            line-height: 1.6;
            color: var(--black);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 15px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #6b7280;
        }

        .header h1 {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }

        .add-villa-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .add-villa-btn:hover {
            background-color: #3a5aef;
        }

        .villas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .villa-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .villa-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .villa-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .villa-details {
            padding: 20px;
        }

        .villa-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .villa-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        .villa-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #f7ba4a;
            color: white;
        }

        .btn-delete {
            background-color: #f74a4a;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e5a63c;
        }

        .btn-delete:hover {
            background-color: #e63c3c;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-available {
            background-color: rgba(74, 222, 128, 0.1);
            color: #4ade80;
        }

        .status-unavailable {
            background-color: rgba(248, 113, 113, 0.1);
            color: #f87171;
        }

        .no-villas {
            text-align: center;
            padding: 50px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <a href="../admin/index.php" class="back-btn">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
                <h1><i class="ri-home-2-line"></i> Daftar Villa</h1>
            </div>
            <a href="add_villa.php" class="add-villa-btn">
                <i class="ri-add-line"></i> Tambah Villa Baru
            </a>
        </div>

        <div class="villas-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($villa = $result->fetch_assoc()): ?>
                    <div class="villa-card">
                        <img src="<?= htmlspecialchars($villa['foto_utama']) ?>" alt="<?= htmlspecialchars($villa['nama_villa']) ?>" class="villa-image">
                        <div class="villa-details">
                            <h2 class="villa-title"><?= htmlspecialchars($villa['nama_villa']) ?></h2>
                            
                            <div class="villa-info">
                                <span>Rp <?= number_format($villa['harga_per_malam'], 0, ',', '.') ?>/malam</span>
                                <span class="status-badge <?= $villa['status'] === 'available' ? 'status-available' : 'status-unavailable' ?>">
                                    <?= $villa['status'] === 'available' ? 'Tersedia' : 'Tidak Tersedia' ?>
                                </span>
                            </div>

                            <div class="villa-info">
                                <span><i class="ri-user-line"></i> <?= $villa['kapasitas'] ?> Tamu</span>
                                <span><i class="ri-hotel-bed-line"></i> <?= $villa['kamar_tidur'] ?> Kamar</span>
                            </div>

                            <div class="villa-actions">
                                <a href="edit_villa.php?id=<?= $villa['id_villa'] ?>" class="btn btn-edit">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <a href="villas.php?delete_id=<?= $villa['id_villa'] ?>" class="btn btn-delete" onclick="return confirm('Hapus villa ini?')">
                                    <i class="ri-delete-bin-line"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-villas">
                    <i class="ri-home-smile-line" style="font-size: 3rem; color: var(--primary-color);"></i>
                    <h2>Belum Ada Villa</h2>
                    <p>Tambahkan villa pertama Anda sekarang!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
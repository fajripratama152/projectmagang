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

// Mengambil data villas
$result = $conn->query("SELECT * FROM villas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-decoration: none;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }

        .villa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 0 auto;
            max-width: 1400px;
        }

        .villa-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .villa-card:hover {
            transform: translateY(-5px);
        }

        .villa-image {
            height: 180px;
            position: relative;
        }

        .villa-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .price-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .villa-content {
            padding: 1rem;
        }

        .villa-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .villa-description {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.8rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .villa-features {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.8rem;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-book {
            background: #2c3e50;
            color: white;
        }

        .btn-book:hover {
            background: #34495e;
        }

        .btn-details {
            background: #f0f2f5;
            color: #2c3e50;
        }

        .btn-details:hover {
            background: #e9ecef;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #4CAF50;
            color: white;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .villa-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <a href="../index.php" class="back-btn">
        <i class="fas fa-arrow-left"></i>
    </a>

    <h1 class="page-title">Villa Collection</h1>

    <div class="villa-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="villa-card">
                    <div class="villa-image">
                        <img src="<?= htmlspecialchars($row['foto_utama']) ?>" 
                             alt="<?= htmlspecialchars($row['nama_villa']) ?>">
                        <div class="price-badge">
                            Rp <?= number_format($row['harga_per_malam'], 0, ',', '.') ?>
                        </div>
                        <div class="status-badge">Available</div>
                    </div>
                    <div class="villa-content">
                        <h2 class="villa-name"><?= htmlspecialchars($row['nama_villa']) ?></h2>
                        <div class="villa-features">
                            <div class="feature">
                                <i class="fas fa-user-friends"></i>
                                <span><?= htmlspecialchars($row['kapasitas']) ?> Tamu</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-bed"></i>
                                <span>3 Kamar</span>
                            </div>
                        </div>
                        <p class="villa-description">
                            <?= htmlspecialchars($row['deskripsi']) ?>
                        </p>
                        <div class="action-buttons">
                            <a href="booking.php?villa_id=<?= $row['id_villa'] ?>" class="btn-action btn-book">Booking</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info w-100 text-center">
                Belum ada villa tersedia.
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

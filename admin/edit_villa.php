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

// Ambil data villa berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM villas WHERE id_villa = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $villa = $result->fetch_assoc();
    } else {
        echo "Data villa tidak ditemukan.";
        exit();
    }
} else {
    header('Location: villas.php');
    exit();
}

// Proses update data villa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_villa = $conn->real_escape_string($_POST['nama_villa']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $harga_per_malam = floatval($_POST['harga_per_malam']);
    $kapasitas = intval($_POST['kapasitas']);
    $kamar_tidur = intval($_POST['kamar_tidur']);
    $status = $conn->real_escape_string($_POST['status']);
    $foto_utama = $villa['foto_utama']; 

    if (!empty($_FILES['foto_utama']['name'])) {
        $target_dir = "../assets/img";
        $foto_utama = $target_dir . basename($_FILES["foto_utama"]["name"]);
        move_uploaded_file($_FILES["foto_utama"]["tmp_name"], $foto_utama);
    }

    $stmt = $conn->prepare("UPDATE villas 
            SET nama_villa = ?, deskripsi = ?, harga_per_malam = ?, 
                kapasitas = ?, kamar_tidur = ?, foto_utama = ?, status = ?
            WHERE id_villa = ?");
    
    $stmt->bind_param("ssdiissi", $nama_villa, $deskripsi, $harga_per_malam, 
                      $kapasitas, $kamar_tidur, $foto_utama, $status, $id);

    if ($stmt->execute()) {
        header("Location: villas.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillaStay - Edit Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-house-gear me-3 fs-4"></i>
                            <h4 class="mb-0">Edit Villa Details</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="edit_villa.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_villa" class="form-label fw-bold">Nama Villa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        <input type="text" class="form-control" id="nama_villa" name="nama_villa" value="<?= htmlspecialchars($villa['nama_villa']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="harga_per_malam" class="form-label fw-bold">Harga per Malam</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga_per_malam" name="harga_per_malam" value="<?= $villa['harga_per_malam'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($villa['deskripsi']) ?></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="kapasitas" class="form-label fw-bold">Kapasitas</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-people"></i></span>
                                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?= $villa['kapasitas'] ?>" required>
                                        <span class="input-group-text">Orang</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="kamar_tidur" class="form-label fw-bold">Kamar Tidur</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-door-closed"></i></span>
                                        <input type="number" class="form-control" id="kamar_tidur" name="kamar_tidur" value="<?= $villa['kamar_tidur'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="available" <?= $villa['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                                        <option value="unavailable" <?= $villa['status'] == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="foto_utama" class="form-label fw-bold">Foto Utama</label>
                                    <input type="file" class="form-control" id="foto_utama" name="foto_utama" accept="image/*">
                                    <div class="form-text text-muted">
                                        <i class="bi bi-image me-2"></i>Foto saat ini: <?= basename($villa['foto_utama']) ?>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <a href="villas.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
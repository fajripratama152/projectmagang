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

// Proses tambah data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_villa = $_POST['nama_villa'];
    $deskripsi = $_POST['deskripsi'];
    $harga_per_malam = $_POST['harga_per_malam'];
    $kapasitas = $_POST['kapasitas'];
    $kamar_tidur = $_POST['kamar_tidur'];
    $status = $_POST['status'];

    // Upload Foto
    $target_dir = "../assets/img/";
    $foto_utama = $target_dir . uniqid() . '_' . basename($_FILES["foto_utama"]["name"]);
    move_uploaded_file($_FILES["foto_utama"]["tmp_name"], $foto_utama);

    // Simpan data ke database
    $sql = "INSERT INTO villas (nama_villa, deskripsi, harga_per_malam, kapasitas, kamar_tidur, foto_utama, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiss", $nama_villa, $deskripsi, $harga_per_malam, $kapasitas, $kamar_tidur, $foto_utama, $status);

    if ($stmt->execute()) {
        header("Location: villas.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillaStay - Tambah Villa Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .form-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 40px;
            margin-top: 50px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
            border-color: #86b7fe;
        }
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed #ced4da;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .file-upload-wrapper:hover {
            border-color: #4e73df;
            background-color: rgba(78,115,223,0.05);
        }
        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        #image-preview {
            max-height: 300px;
            margin-top: 15px;
            border-radius: 10px;
        }
        .btn-custom-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            transition: all 0.3s ease;
        }
        .btn-custom-primary:hover {
            background-color: #3a5ad0;
            border-color: #3a5ad0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <h2 class="h3 mb-3 fw-bold text-primary">
                            <i class="bi bi-house-add me-2"></i>Tambah Villa Baru
                        </h2>
                        <p class="text-muted">Lengkapi informasi detail villa Anda dengan cermat</p>
                    </div>

                    <form action="add_villa.php" method="POST" enctype="multipart/form-data">
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i><?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_villa" class="form-label">Nama Villa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
                                    <input type="text" class="form-control" id="nama_villa" name="nama_villa" required placeholder="Masukkan nama villa">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_per_malam" class="form-label">Harga per Malam</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga_per_malam" name="harga_per_malam" required placeholder="Harga per malam">
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Deskripsi Villa</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required placeholder="Deskripsikan villa Anda secara detail"></textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="kapasitas" class="form-label">Kapasitas Tamu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" required placeholder="Jumlah tamu">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="kamar_tidur" class="form-label">Kamar Tidur</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-door-closed-fill"></i></span>
                                    <input type="number" class="form-control" id="kamar_tidur" name="kamar_tidur" required placeholder="Jumlah kamar">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label">Status Villa</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available">Tersedia</option>
                                    <option value="unavailable">Tidak Tersedia</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Foto Utama Villa</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="file-upload-input" name="foto_utama" id="foto_utama" accept="image/*" required onchange="previewImage(this)">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-cloud-upload fs-2 text-primary mb-2"></i>
                                        <p class="text-muted mb-0">Klik untuk unggah atau seret gambar ke sini</p>
                                    </div>
                                    <img id="image-preview" class="img-fluid" style="display:none;">
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <a href="villas.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-custom-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Villa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
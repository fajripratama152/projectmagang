<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RajaAmpat Islands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #2d3436;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
        }

        .nav-link {
            color: #2d3436 !important;
            font-weight: 500;
            padding: 8px 16px !important;
            margin: 0 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #FFA500;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover:before {
            width: 80%;
        }

        .nav-link:hover {
            color: #FFA500 !important;
            background: rgba(255, 165, 0, 0.1);
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 1.1em;
        }

        .btn-sign-in {
            background: linear-gradient(45deg, #FFA500, #FF8C00);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 165, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-sign-in:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 165, 0, 0.4);
            background: linear-gradient(45deg, #FF8C00, #FFA500);
        }

        .navbar-toggler {
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            position: relative;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler .toggler-icon {
            display: block;
            width: 100%;
            height: 2px;
            background: #2d3436;
            margin: 5px 0;
            transition: all 0.3s ease;
        }

        .navbar-toggler[aria-expanded="true"] .toggler-icon:first-child {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .navbar-toggler[aria-expanded="true"] .toggler-icon:nth-child(2) {
            opacity: 0;
        }

        .navbar-toggler[aria-expanded="true"] .toggler-icon:last-child {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                padding: 20px;
                border-radius: 10px;
                margin-top: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-link {
                margin: 5px 0;
            }

            .btn-sign-in {
                margin-top: 10px;
                width: 100%;
            }
        }

        /* Hero Section Styles */
        .hero-section {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: calc(100vh - 76px);
            position: relative;
            overflow: hidden;
            padding: 80px 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?ixlib=rb-4.0.3') center/cover no-repeat;
            opacity: 0.2;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .text-container {
            max-width: 600px;
            padding: 40px 20px;
        }

        .text-container h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .text-container h1 span {
            background: linear-gradient(45deg, #FFA500, #FF8C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
        }

        .text-container p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .image-container {
            position: relative;
            z-index: 2;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: perspective(1000px) rotateY(-15deg);
            transition: all 0.5s ease;
        }

        .image-container:hover img {
            transform: perspective(1000px) rotateY(0deg);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 991.98px) {
            .hero-section {
                text-align: center;
            }

            .text-container {
                margin: 0 auto;
                padding-bottom: 40px;
            }

            .image-container img {
                transform: none;
                margin: 0 auto;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
    <a class="navbar-brand" href="#">
    <i class="fas fa-hotel"></i>
    RajaAmpat
</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
        </button>
 
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="user/villa.php">
                        <i class="fas fa-hotel"></i>Villas
                    </a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-sign-in" href="login.php">Sign in</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="floating-shapes">
        <div class="shape" style="left: 10%; top: 20%; width: 80px; height: 80px;"></div>
        <div class="shape" style="right: 15%; top: 40%; width: 60px; height: 60px;"></div>
        <div class="shape" style="left: 20%; bottom: 20%; width: 40px; height: 40px;"></div>
    </div>
    <div class="container">
        <div class="row align-items-center hero-content">
            <div class="col-lg-6">
                <div class="text-container">
                    <h1>Villa di <span>Kepulauan Raja Ampat</span></h1>
                    <p>Enjoy the magic of Raja Ampat in luxury! Wake up in a villa overlooking the clear sea, enjoy the beauty of coral reefs, and let your holiday become an unforgettable memory in this tropical paradise.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="image-container">
                    <img src="assets/img/raaj.jpg" alt="Gambar Raja Ampat">
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navb6grqwsar.classList.remove('scrolled');
        }
    });
</script>

</body>
</html>
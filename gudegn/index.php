<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('img/latar2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head> 
<body>
    <nav class="navbar" style="background-color: #333;"> <!-- Change background color to lightcoral -->
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>

        <div class="navbar-nav">
            <?php if (isset($_SESSION['fullname'])): ?>
                <span>Welcome, <?php echo $_SESSION['fullname']; ?></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="index.php">Home</a>
                <a href="tentang.php">About</a>
                <a href="menu.php">Menu</a>
                <a href="kontak.php">Contact</a>
                <?php if (basename($_SERVER['PHP_SELF']) == 'login.php'): ?>
                    <a href="register.php">Register</a>
                <?php endif; ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>

        <div class="navbar-extra">
            <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i><span id="cart-count">0</span></a>
        </div>
    </nav>

    <div id="cart-items" class="cart-items-container">
        <div id="total-price-container">
            Total: <span id="total-price">0</span>
        </div>
        <button id="makan-di-tempat" class="btn">Makan di Tempat</button>
        <button id="pesan-online" class="btn">Pesan Online</button>
    </div>
  
    <div class="hero" style="display: flex; justify-content: center; background-color: rgba(184, 137, 18, 0.42);">
        <div class="mask-container"> <!-- Added inline style for background color and opacity -->
            <main class="content">
                <h1>Selamat Datang di Website Gudeg Ibu Dirjo</h1>
                <p style="font-family: 'Playfair Display', serif;">Jam Operasional :</p>
                <p style="font-family: 'Playfair Display', serif;">Senin-Minggu 10.00-16.30</p>
                <p style="font-size: 14px; font-family: 'Playfair Display', serif;">Sebelum memesan menu kami, silahkan login ke akun anda dahulu</p>
                <a href="login.php" class="btn" style="font-family: 'Playfair Display', serif;">Klik untuk masuk</a>
            </main>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
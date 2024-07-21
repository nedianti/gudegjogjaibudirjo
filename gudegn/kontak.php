<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add background color to the contact section */
        .contact-us {
            background-color: #eabe6e; /* Choose the desired background color */
            padding: 20px; /* Add padding for better visual appearance */
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>

        <div class="navbar-nav">
            <a href="index.php">Home</a>
            <a href="tentang.php">About</a>
            <a href="menu.php">Menu</a>
            <a href="kontak.php">Contact</a>
            <a href="login.php">Login</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i><span id="cart-count">0</span></a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>

    <section class="contact-us">
        <div class="contact-container">
            <h1>Kontak Kami</h1>
            <p>Jika Anda memiliki pertanyaan atau ingin menghubungi kami, silakan gunakan informasi di bawah ini.</p>
            <div class="contact-info">
                <div class="contact-item">
                    <h2>Alamat</h2>
                    <p>Gg.Bima Jaya Pasar Minggu Jakarta Selatan</p>
                </div>
                <div class="contact-item">
                    <h2>Telepon</h2>
                    <p>+62 878 4328 3461</p>
                </div>
                <div class="contact-item">
                    <h2>Email</h2>
                    <p>info@gudegjogjaibudirjo.com</p>
                </div>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8319803246927!2d106.84036071014252!3d-6.285804661499233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f26d3e7849cb%3A0xcbad1e52eb2e5cb1!2sGg.%20Bima%20Jaya%2C%20Ps.%20Minggu%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012520!5e0!3m2!1sid!2sid!4v1718416474193!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
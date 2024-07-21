<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>
        <div class="navbar-nav">
            <a href="index.php">Home</a>
            <a href="tentang.php">Tentang Kami</a>
            <a href="menu.php">Daftar Menu Kami</a>
            <a href="kontak.php">Contact</a>
            <a href="login.php">Login</a>
        </div>
    </nav>

    <section class="payment-section">
        <h2>Pembayaran</h2>
        <p>Total Harga: <span id="total-price-display">0</span></p>
        <form>
            <label for="payment-method">Pilih Metode Pembayaran:</label>
            <select id="payment-method" name="payment-method">
                <option value="bank-transfer">Transfer Bank</option>
                <option value="cash">Tunai/COD</option>
            </select>
            <button type="submit" class="btn-bayar">Bayar</button>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalPrice = localStorage.getItem('totalPrice');
            document.getElementById('total-price-display').textContent = parseInt(totalPrice).toLocaleString();
        });
    </script>
</body>
</html>

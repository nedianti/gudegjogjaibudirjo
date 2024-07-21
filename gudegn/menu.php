<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
      background-size: cover; /* Add this line */
      background-repeat: no-repeat; /* Add this line */
      background-position: center; /* Add this line */
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #333;
      color: white;
      padding: 15px 20px;
    }

    .navbar-logo {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      text-decoration: none;
      color: white;
    }

    .navbar-nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-size: 18px;
    }

    .navbar-nav span {
      margin-right: 15px;
      font-size: 18px;
    }

    .navbar-extra {
      display: flex;
      align-items: center;
    }

    .navbar-extra a {
      color: white;
      text-decoration: none;
      position: relative;
    }

    #cart-count {
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 3px 6px;
      position: absolute;
      top: -10px;
      right: -10px;
      font-size: 14px;
    }

    .menu-items {
      background-color: #eabe6e; 
      width: 100%; /* Change max-width to width */
      margin: 0; /* Remove auto margin */
      padding: 20px;
    }

    .menu-items h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr); /* Ensure 3 items per row */
      gap: 20px;
    }

    .menu-item {
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      margin-bottom: 20px; /* Added margin-bottom for spacing */
    }

    .menu-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .menu-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s;
    }

    .menu-item:hover img {
      transform: scale(1.05);
    }

    .menu-item h3 {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      margin: 10px 0;
    }

    .menu-item p {
      font-size: 16px;
      color: #666;
    }

    .menu-item .price {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .menu-item .rating {
      margin: 10px 0;
    }

    .menu-item .star {
      cursor: pointer;
      font-size: 24px;
      color: gray;
    }

    .menu-item .star.selected {
      color: gold;
    }

    .menu-item .btn-pesan {
      background-color: #f0ad4e;
      border: none;
      color: white;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      border-radius: 5px;
      width: 80%;
      transition: background-color 0.3s;
    }

    .menu-item .btn-pesan:hover {
      background-color: #ec971f;
    }

    .cart-items-container {
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 5px;
      width: 300px;
      margin: 20px auto;
    }

    #total-price-container {
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .btn-order {
      background-color: #f0ad4e;
      border: none;
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      flex: 1;
      margin: 0 5px;
      transition: transform 0.3s, background-color 0.3s; /* Smooth transition */
    }

    .btn-order:hover {
      background-color: #ec971f; /* Change background color on hover */
      transform: scale(1.05); /* Slightly increase the size */
    }

    .btn-order:first-child {
      margin-left: 0;
    }

    .btn-order:last-child {
      margin-right: 0;
    }

    .cart-modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%; /* Make the modal full width */
      height: 100%; /* Make the modal full height */
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .cart-modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px; /* Limit the maximum width if needed */
      border-radius: 10px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .quantity-controls {
      display: flex;
      align-items: center;
    }

    .quantity-controls button {
      background-color: #f0ad4e;
      border: none;
      color: white;
      padding: 5px 10px;
      cursor: pointer;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .cart-item span {
      margin: 0 10px;
    }
  </style>
</head>
<body>
    <nav class="navbar">
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
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>

        <div class="navbar-extra">
            <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i><span id="cart-count">0</span></a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>

    <section class="menu-items">
        <h2>Daftar Menu</h2>
        <div class="menu-grid">
            <div class="menu-item">
                <img src="img/krecek.jpg" alt="Krecek">
                <h3>Krecek</h3>
                <p>Komposisi: Kulit sapi, cabai merah, bawang merah, bawang putih, lengkuas, daun salam, santan, gula merah, garam.</p>
                <p>Rasa: Pedas dan gurih dengan tekstur kenyal.</p>
                <span class="price">15000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Krecek" data-price="15000">Pesan</button>
            </div>
            <div class="menu-item">
                <img src="img/gudeg.jpg" alt="Gudeg">
                <h3>Gudeg</h3>
                <p>Komposisi: Nangka muda, santan, bawang merah, bawang putih, lengkuas, daun salam, serai, gula merah, garam, ketumbar.</p>
                <p>Rasa: Manis dan gurih dengan tekstur empuk dari nangka.</p>
                <span class="price">15000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Gudeg" data-price="15000">Pesan</button>
            </div>
            <div class="menu-item">
                <img src="img/tempetahu.jpg" alt="Tahu/Tempe Bacem">
                <h3>Tahu/Tempe Bacem</h3>
                <p>Komposisi: Tahu atau tempe, gula merah, kecap manis, bawang merah, bawang putih, ketumbar, daun salam, lengkuas, air kelapa (opsional), garam.</p>
                <p>Rasa: Manis dan gurih dengan sedikit aroma rempah.</p>
                <span class="price">8000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Tahu/Tempe Bacem" data-price="8000">Pesan</button>
            </div>
            <div class="menu-item">
                <img src="img/perkedel.jpg" alt="Perkedel">
                <h3>Perkedel</h3>
                <p>Komposisi: Kentang, daging cincang (opsional), bawang merah, bawang putih, daun seledri, telur, garam, merica.</p>
                <p>Rasa: Gurih dan lembut di dalam, renyah di luar.</p>
                <span class="price">4000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Perkedel" data-price="4000">Pesan</button>
            </div>
            <div class="menu-item">
                <img src="img/bihun.jpg" alt="Bihun">
                <h3>Bihun</h3>
                <p>Komposisi: Bihun (tepung beras), bawang putih, kecap asin, kecap manis, sayuran (seperti wortel, kol), daun bawang, garam, merica, minyak.</p>
                <p>Rasa: Gurih dan sedikit manis dengan tekstur lembut dan kenyal.</p>
                <span class="price">5000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Bihun" data-price="5000">Pesan</button>
            </div>
            <div class="menu-item">
                <img src="img/tahu_opor.jpg" alt="Tahu Opor">
                <h3>Tahu Opor</h3>
                <p>Komposisi: Tahu, santan, bawang merah, bawang putih, kunyit, ketumbar, kemiri, daun salam, lengkuas, garam, gula.</p>
                <p>Rasa: Gurih dengan aroma rempah yang kuat, tekstur tahu yang lembut.</p>
                <span class="price">5000</span>
                <div class="rating">
                    <span class="star" data-value="5">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="1">&#9733;</span>
                </div>
                <button class="btn-pesan" data-item="Tahu Opor" data-price="5000">Pesan</button>
            </div>
        </div>
    </section>

    <div id="cart-items-dine-in" class="cart-items-container">
        <h3>Keranjang Makan di Tempat</h3>
        <p>Nama: <span id="user-fullname-dine-in"><?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Guest'; ?></span></p>
        <ul id="cart-list-dine-in"></ul>
        <div id="total-price-container-dine-in">
            Total: <span id="total-price-dine-in">0</span>
            <div class="button-container">
                <button id="btn-dine-in" class="btn-order">Makan di Tempat</button>
            </div>
        </div>
    </div>

    <div id="cart-items-order-online" class="cart-items-container">
        <h3>Keranjang Pesan Online</h3>
        <p>Nama: <span id="user-fullname-order-online"><?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Guest'; ?></span></p>
        <ul id="cart-list-order-online"></ul>
        <div id="total-price-container-order-online">
            Total: <span id="total-price-order-online">0</span>
            <div class="button-container">
                <button id="btn-order-online" class="btn-order">Pesan Online</button>
            </div>
        </div>
    </div>

    <div id="cart-modal" class="cart-modal">
        <div class="cart-modal-content">
            <span class="close">&times;</span>
            <h2>Keranjang Belanja</h2>
            <ul id="cart-list-modal"></ul>
            <div id="total-price-container-modal">
                Total: <span id="total-price-modal">0</span>
            </div>
            <div class="button-container">
                <a id="btn-dine-in" class="btn-order" href="dine_in.php">Makan di Tempat</a>
                <a id="btn-order-online" class="btn-order" href="order_online.php">Pesan Online</a>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartListDineIn = document.getElementById('cart-list-dine-in');
            const cartListOrderOnline = document.getElementById('cart-list-order-online');
            const cartListModal = document.getElementById('cart-list-modal');
            const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            const user = JSON.parse(localStorage.getItem('user')) || { fullname: 'Guest' };
            const cartCountElement = document.getElementById('cart-count');
            const cartModal = document.getElementById('cart-modal');
            const closeModal = document.querySelector('.close');
            const btnDineIn = document.getElementById('btn-dine-in');
            const btnOrderOnline = document.getElementById('btn-order-online');

            if (document.getElementById('user-fullname-dine-in')) {
                document.getElementById('user-fullname-dine-in').textContent = user.fullname;
            }
            if (document.getElementById('user-fullname-order-online')) {
                document.getElementById('user-fullname-order-online').textContent = user.fullname;
            }

            function renderCartItems() {
                if (cartListDineIn) {
                    cartListDineIn.innerHTML = cartItems.map((item, index) => `
                        <li data-item="${item.name}" data-price="${item.price}">
                            ${item.name} - ${item.quantity} x ${parseInt(item.price).toLocaleString()}
                            <span class="quantity">${item.quantity}</span>
                        </li>
                    `).join('');
                }

                if (cartListOrderOnline) {
                    cartListOrderOnline.innerHTML = cartItems.map((item, index) => `
                        <li data-item="${item.name}" data-price="${item.price}">
                            ${item.name} - ${item.quantity} x ${parseInt(item.price).toLocaleString()}
                            <span class="quantity">${item.quantity}</span>
                        </li>
                    `).join('');
                }

                if (cartListModal) {
                    cartListModal.innerHTML = cartItems.map((item, index) => `
                        <div class="cart-item" data-index="${index}">
                            <span>${item.name}</span>
                            <span>${parseInt(item.price).toLocaleString()}</span>
                            <div class="quantity-controls">
                                <button class="btn-decrease">-</button>
                                <span class="quantity">${item.quantity}</span>
                                <button class="btn-increase">+</button>
                            </div>
                            <button class="btn-delete">Delete</button>
                        </div>
                    `).join('');
                }

                updateTotalPrice();
                updateCartCount();
            }

            function updateTotalPrice() {
                let totalPrice = cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
                if (document.getElementById('total-price-dine-in')) {
                    document.getElementById('total-price-dine-in').textContent = totalPrice.toLocaleString();
                }
                if (document.getElementById('total-price-order-online')) {
                    document.getElementById('total-price-order-online').textContent = totalPrice.toLocaleString();
                }
                if (document.getElementById('total-price-modal')) {
                    document.getElementById('total-price-modal').textContent = totalPrice.toLocaleString();
                }
                localStorage.setItem('totalPrice', totalPrice);
            }

            function updateCartCount() {
                const totalItems = cartItems.reduce((total, item) => total + item.quantity, 0);
                if (cartCountElement) {
                    cartCountElement.textContent = totalItems;
                }
            }

            function saveCartItems() {
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
            }

            document.querySelectorAll('.btn-pesan').forEach(button => {
                button.addEventListener('click', function() {
                    const itemName = this.getAttribute('data-item');
                    const itemPrice = parseInt(this.getAttribute('data-price'));
                    const existingItem = cartItems.find(item => item.name === itemName);

                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        cartItems.push({ name: itemName, price: itemPrice, quantity: 1 });
                    }

                    saveCartItems();
                    renderCartItems();
                });
            });

            if (btnDineIn) {
                btnDineIn.addEventListener('click', function() {
                    saveCartItems();
                    window.location.href = 'dine_in.php';
                });
            }

            if (btnOrderOnline) {
                btnOrderOnline.addEventListener('click', function() {
                    saveCartItems();
                    window.location.href = 'order_online.php';
                });
            }

            if (document.getElementById('shopping-cart-button')) {
                document.getElementById('shopping-cart-button').addEventListener('click', function() {
                    cartModal.style.display = 'block';
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', function() {
                    cartModal.style.display = 'none';
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target == cartModal) {
                    cartModal.style.display = 'none';
                }
            });

            cartListModal.addEventListener('click', function(event) {
                const target = event.target;
                const cartItem = target.closest('.cart-item');
                const index = cartItem.getAttribute('data-index');
                const quantityElement = cartItem.querySelector('.quantity');

                if (target.classList.contains('btn-decrease')) {
                    if (cartItems[index].quantity > 1) {
                        cartItems[index].quantity--;
                        quantityElement.textContent = cartItems[index].quantity;
                        saveCartItems();
                        updateTotalPrice();
                        updateCartCount();
                    }
                } else if (target.classList.contains('btn-increase')) {
                    cartItems[index].quantity++;
                    quantityElement.textContent = cartItems[index].quantity;
                    saveCartItems();
                    updateTotalPrice();
                    updateCartCount();
                } else if (target.classList.contains('btn-delete')) {
                    cartItems.splice(index, 1);
                    saveCartItems();
                    cartItem.remove();
                    updateTotalPrice();
                    updateCartCount();
                }
            });

            renderCartItems();
        });
    </script>
</body>
</html>

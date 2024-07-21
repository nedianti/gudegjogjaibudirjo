<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makan di Tempat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .cart-item span {
            margin: 0 10px;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>
        <div class="navbar-nav">
            <span id="user-greeting"><?php echo isset($_SESSION['fullname']) ? 'Welcome, ' . $_SESSION['fullname'] : ''; ?></span>
            <a href="logout.php" id="logout-link" style="display: <?php echo isset($_SESSION['fullname']) ? 'block' : 'none'; ?>;">Logout</a>
        </div>
    </nav>

    <section class="order-section">
        <h2>Makan di Tempat</h2>
        <p>Nama: <span id="user-name"><?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Guest'; ?></span></p>
        <p>Rincian Pesanan:</p>
        <ul id="order-details"></ul>
        <div id="order-items"></div>
        <p>Total Harga: <span id="total-price"></span></p>
        <form id="order-form" enctype="multipart/form-data">
            <label for="payment-method">Metode Pembayaran:</label>
            <select id="payment-method" name="payment-method">
                <option value="TUNAI">Tunai</option>
                <option value="TF">Transfer</option>
            </select>
            <div id="upload-proof" style="display: none;">
                <label for="payment-proof">Unggah Bukti Pembayaran:</label>
                <input type="file" id="payment-proof" name="payment-proof" accept="image/*">
            </div>
            <button type="submit" class="btn-order">Bayar</button>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const user = JSON.parse(localStorage.getItem('user'));
            const orderItems = JSON.parse(localStorage.getItem('cartItems'));
            let totalPrice = localStorage.getItem('totalPrice');

            if (user) {
                document.getElementById('user-name').textContent = user.fullname;
                document.getElementById('user-greeting').textContent = `Welcome, ${user.fullname}`;
                document.getElementById('logout-link').style.display = 'block';
            }

            const orderItemsContainer = document.getElementById('order-items');
            const orderDetailsContainer = document.getElementById('order-details');
            orderItemsContainer.innerHTML = orderItems.map((item, index) => `
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

            orderDetailsContainer.innerHTML = orderItems.map(item => `
                <li>${item.name} - ${item.quantity} x ${parseInt(item.price).toLocaleString()}</li>
            `).join('');

            function updateTotalPrice() {
                totalPrice = orderItems.reduce((total, item) => total + (item.price * item.quantity), 0);
                document.getElementById('total-price').textContent = totalPrice.toLocaleString();
                localStorage.setItem('totalPrice', totalPrice);
            }

            orderItemsContainer.addEventListener('click', function(event) {
                const target = event.target;
                const cartItem = target.closest('.cart-item');
                const index = cartItem.getAttribute('data-index');
                const quantityElement = cartItem.querySelector('.quantity');

                if (target.classList.contains('btn-decrease')) {
                    if (orderItems[index].quantity > 1) {
                        orderItems[index].quantity--;
                        quantityElement.textContent = orderItems[index].quantity;
                        localStorage.setItem('cartItems', JSON.stringify(orderItems));
                        updateTotalPrice();
                    }
                } else if (target.classList.contains('btn-increase')) {
                    orderItems[index].quantity++;
                    quantityElement.textContent = orderItems[index].quantity;
                    localStorage.setItem('cartItems', JSON.stringify(orderItems));
                    updateTotalPrice();
                } else if (target.classList.contains('btn-delete')) {
                    orderItems.splice(index, 1);
                    localStorage.setItem('cartItems', JSON.stringify(orderItems));
                    cartItem.remove();
                    updateTotalPrice();
                }
            });

            updateTotalPrice();

            const paymentMethodSelect = document.getElementById('payment-method');
            const uploadProofDiv = document.getElementById('upload-proof');

            paymentMethodSelect.addEventListener('change', function() {
                if (paymentMethodSelect.value === 'TF') {
                    uploadProofDiv.style.display = 'block';
                } else {
                    uploadProofDiv.style.display = 'none';
                }
            });

            document.getElementById('order-form').addEventListener('submit', function(event) {
                event.preventDefault();

                const paymentMethod = document.getElementById('payment-method').value;
                const paymentProof = document.getElementById('payment-proof').files[0];

                // Tambahkan pemeriksaan untuk bukti pembayaran
                if (paymentMethod === 'TF' && !paymentProof) {
                    alert('Silakan unggah bukti pembayaran.');
                    return;
                }

                const formData = new FormData();
                formData.append('user_id', <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>);
                formData.append('items', JSON.stringify(orderItems));
                formData.append('total_price', parseInt(totalPrice));
                formData.append('payment_method', paymentMethod);
                formData.append('order_type', 'dine-in');
                if (paymentProof) {
                    formData.append('payment-proof', paymentProof);
                }

                fetch('save_order.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert('Order successfully saved!');
                    window.location.href = 'user_dashboard.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>
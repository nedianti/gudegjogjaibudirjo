<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header('Location: login.php'); // Redirect to login page if not admin
    exit();
}

include 'db.php';

$sql = "SELECT orders.id, users.fullname, orders.items, orders.total_price, orders.payment_method, orders.order_type, orders.status, orders.payment_proof FROM orders JOIN users ON orders.user_id = users.id";
$result = $conn->query($sql);

$rows = [];
while($row = $result->fetch_assoc()) {
    array_unshift($rows, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-section {
            margin: 0 auto;
            max-width: 1000px;
            width: 100%;
            padding: 0 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .lunas-button {
            background-color: green;
            color: white;
        }
        .status-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .status-button.completed {
            background-color: green;
            cursor: not-allowed;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.9);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .admin-section {
                padding: 0 10px;
            }
            table, th, td {
                font-size: 14px;
            }
            .navbar-nav {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar-nav a {
                margin: 5px 0;
            }
        }
        @media (max-width: 480px) {
            .navbar-logo {
                font-size: 18px;
            }
            .navbar-nav span {
                font-size: 14px;
            }
            .status-button, .print-button {
                padding: 3px 5px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>
        <div class="hamburger-menu">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="navbar-nav">
            <span>Welcome, <?php echo $_SESSION['fullname']; ?></span>
            <a href="user_management.php">Manage Users</a> <!-- Link to user management page -->
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <section class="admin-section">
        <h2>Admin Toko</h2>
        <h3>Daftar Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Items</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Jenis Pesanan</th>
                    <th>Status</th>
                    <th>Payment Proof</th>
                    <th>Print</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $row): ?>
                <tr id="order-row-<?php echo $row['id']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td>
                        <ul>
                            <?php 
                                $items = json_decode($row['items'], true);
                                foreach ($items as $item) {
                                    echo "<li>Name: " . $item['name'] . ", Price: " . $item['price'] . ", Quantity: " . $item['quantity'] . "</li>";
                                }
                            ?>
                        </ul>
                    </td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['order_type']; ?></td>
                    <td>
                        <button onclick="setStatus(<?php echo $row['id']; ?>, this)" class="status-button <?php echo $row['status'] == 'completed' ? 'completed' : ''; ?>" data-order-id="<?php echo $row['id']; ?>" <?php echo $row['status'] == 'completed' ? 'disabled' : ''; ?>>
                            <?php echo $row['status'] == 'completed' ? 'Selesai' : 'Pending'; ?>
                        </button>
                    </td>
                    <td>
                        <?php if ($row['payment_proof']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['payment_proof']); ?>" alt="Payment Proof" style="width: 100px; height: auto;" onclick="openModal(this)">
                        <?php else: ?>
                            No Proof
                        <?php endif; ?>
                    </td>
                    <td><button onclick="printOrder(<?php echo $row['id']; ?>)" class="print-button" data-order-id="<?php echo $row['id']; ?>">Print</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-section, #print-section * {
                visibility: visible;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

    <script>
        function setStatus(orderId, button) {
            if (button.classList.contains('completed')) {
                return; // Do nothing if the status is already completed
            }

            // Send AJAX request to update status
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        button.innerText = 'Selesai';
                        button.classList.add('completed'); // Mengubah warna tombol menjadi hijau
                        button.classList.remove('status-button'); // Menghapus kelas status-button
                        button.disabled = true; // Menonaktifkan tombol
                    } else {
                        alert('Failed to update status.');
                    }
                }
            };
            xhr.send('orderId=' + orderId + '&status=completed');
        }

        function printOrder(orderId) {
            // Cetak hanya bagian yang dipilih
            var printContents = document.getElementById('order-row-' + orderId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function openModal(img) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modal.style.display = "block";
            modalImg.src = img.src;
            captionText.innerHTML = img.alt;
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
    <script src="script.js"></script>
</body>
</html>
<?php $conn->close(); ?>
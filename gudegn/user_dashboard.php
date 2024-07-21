<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

$sql = "SELECT orders.id, users.fullname, orders.items, orders.total_price, orders.payment_method, orders.status, orders.payment_proof
        FROM orders
        JOIN users ON orders.user_id = users.id
        WHERE users.username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>
        <div class="navbar-nav">
            <span>Welcome, <?php echo $_SESSION['fullname']; ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <section class="user-section">
        <h2>Welcome to your dashboard, <?php echo $_SESSION['fullname']; ?></h2>
        <p>Here you can view your orders and manage your account.</p>
    </section>

    <?php
    if ($result->num_rows > 0) {
        echo "<h2>Your Orders</h2>";
        echo "<table>";
        echo "<tr><th>Order ID</th><th>Fullname</th><th>Items</th><th>Total Price</th><th>Payment Method</th><th>Status</th><th>Payment Proof</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['fullname'] . "</td>";
            echo "<td>";
            $items = json_decode($row['items'], true);
            foreach ($items as $item) {
                echo $item['name'] . " (Qty: " . $item['quantity'] . ")<br>";
            }
            echo "</td>";
            echo "<td>" . $row['total_price'] . "</td>";
            echo "<td>" . $row['payment_method'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>";
            if ($row['payment_proof']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['payment_proof']) . '" alt="Payment Proof" style="width: 100px; height: auto;" onclick="openModal(this)">';
            } else {
                echo 'No Proof';
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You have no orders.</p>";
    }
    $stmt->close();
    $conn->close();
    ?>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>

    <script>
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
</body>
</html>



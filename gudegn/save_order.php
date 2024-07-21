<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $items = $_POST['items'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $order_type = $_POST['order_type'];
    $payment_proof = null;

    // Cek apakah ada file yang diunggah
    if (isset($_FILES['payment-proof']) && $_FILES['payment-proof']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['payment-proof']['tmp_name'];
        $payment_proof = file_get_contents($fileTmpPath);
    }

    // Simpan data ke database
    $sql = "INSERT INTO orders (user_id, items, total_price, payment_method, order_type, payment_proof) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $items, $total_price, $payment_method, $order_type, $payment_proof);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save order']);
    }

    $stmt->close();
    $conn->close();
}
?>

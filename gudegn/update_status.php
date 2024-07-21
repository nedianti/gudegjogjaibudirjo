<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $orderId);

    if ($stmt->execute()) {
        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status';
    }

    $stmt->close();
    $conn->close();
}
?>

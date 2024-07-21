<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header('Location: login.php'); // Redirect to login page if not admin
    exit();
}

include 'db.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Delete related orders first
    $sql = "DELETE FROM orders WHERE user_id=$id";
    if ($conn->query($sql) === TRUE) {
        // Now delete the user
        $sql = "DELETE FROM users WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $delete_message = "User deleted successfully.";
        } else {
            $delete_message = "Error deleting user: " . $conn->error;
        }
    } else {
        $delete_message = "Error deleting related orders: " . $conn->error;
    }
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = [];
while($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-section {
            margin: 0 auto;
            max-width: 1000px;
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        .btn {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-edit {
            background-color: blue;
        }
        .btn-edit:hover {
            background-color: darkblue;
        }
        .btn-delete {
            background-color: red;
        }
        .btn-delete:hover {
            background-color: darkred;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .message {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
    </style>
</head>
<body style="background-image: url('img/latar2.jpg'); background-size: cover;">
    <nav class="navbar">
        <a href="admin_dashboard.php" class="navbar-logo">GUDEG JOGJA IBU DIRJO</a>
        <div class="navbar-nav">
            <span>Welcome, <?php echo $_SESSION['fullname']; ?></span>
            <a href="admin_dashboard.php">Dashboard</a> <!-- Link to admin dashboard -->
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <section class="admin-section">
        <h2>Admin Web</h2>
        <h3>Manage Users</h3>
        <?php if (isset($delete_message)): ?>
            <div class="message"><?php echo $delete_message; ?></div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['fullname']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['address']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="user_management.php?delete=<?php echo $user['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah anda yakin ingin menghapus user ini?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
<?php $conn->close(); ?>


<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header('Location: login.php'); // Redirect to login page if not admin
    exit();
}

include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Handle form submission for updating user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $sql = "UPDATE users SET fullname='$fullname', username='$username', email='$email', address='$address', password='$password' WHERE id=$id";
    $conn->query($sql);

    header('Location: user_management.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-section {
            margin: 0 auto;
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <h2>Edit User</h2>
        <form method="POST" action="edit_user.php?id=<?php echo $id; ?>">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" value="<?php echo $user['fullname']; ?>" required>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
            <label for="address">Address:</label>
            <textarea name="address" id="address" required><?php echo $user['address']; ?></textarea>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <small>Abaikan password jika tidak ingin menggantinya</small>
            <button type="submit" class="btn">Save</button>
        </form>
    </section>
</body>
</html>
<?php $conn->close(); ?>


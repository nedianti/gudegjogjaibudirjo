<?php
session_start();
include 'db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];

            echo "<script>
                localStorage.setItem('user', JSON.stringify({
                    id: '{$user['id']}',
                    username: '{$user['username']}',
                    fullname: '{$user['fullname']}'
                }));
            </script>";

            if ($username == "admin" && password_verify($password, $user["password"])) {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: menu.php');
            }
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "User tidak ditemukan!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
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
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <section class="login-section">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </section>
    <!-- Add background image to the body -->
<body style="background-image: url('img/latar2.jpg'); background-size: cover;">
</body>
</html>
<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<title>Register</title></head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php"><img src="<?php echo $_SESSION['profile_pic']; ?>" class="profile-icon" alt="Profile"></a></li>
            <li><a href="scoreboard.php">Scoreboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
<form method="POST">
    <label>Username:</label><input type="text" name="username" required><br>
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
</body>
</html>

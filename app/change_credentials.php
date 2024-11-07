<?php
session_start();
require 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch the user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Handle form submission for updating user credentials
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Check if password is set
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; // Check if confirm password is set

    // Validate the inputs
    $errors = [];

    // Check if username or email are empty
    if (empty($username)) {
        $errors[] = "Username cannot be empty.";
    }
    if (empty($email)) {
        $errors[] = "Email cannot be empty.";
    }

    // Check if password is provided and matches the confirmation
    if (!empty($password) && $password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, proceed with updating the credentials
    if (empty($errors)) {
        // Hash the password if it's provided (only hash if new password is set)
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password_hash = $user['password']; // Keep the existing password if no new one is set
        }

        // Prepare the query for updating the user's data
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password_hash = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, $password_hash, $user_id]);

        // Redirect to profile page after successful update
        header('Location: profile.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Credentials - FoodShare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Change Credentials Form -->
<div class="form-container">
    <h2>Change Your Credentials</h2>

    <!-- Display errors if there are any -->
    <?php if (!empty($errors)): ?>
        <ul class="error-messages">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Form for changing username, email, and password -->
    <form method="POST" action="change_credentials.php">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="password">New Password (leave empty if not changing):</label>
        <input type="password" name="password"><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password"><br>

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>

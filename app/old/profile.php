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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - FoodShare</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function openImagePopup() {
            document.getElementById('imagePopup').style.display = 'block';
        }
        
        function closeImagePopup() {
            document.getElementById('imagePopup').style.display = 'none';
        }
    </script>
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Profile Section -->
<div class="profile-container">
    <h2>Profile</h2>

    <!-- Profile Image Section -->
    <div class="profile-image-section">
        <img src="<?php echo $user['profile_pic'] ? $user['profile_pic'] : 'default-profile.jpg'; ?>" alt="Profile Picture" class="profile-image" onclick="openImagePopup()">
    </div>

    <!-- Profile Details -->
    <div class="profile-details">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        
        <a href="change_credentials.php" class="change-credentials-link">Change Username, Email, or Password</a>
    </div>

    <!-- Card Information Section -->
    <div class="card-info">
        <h3>Card Information</h3>
        <?php
        // Check if the user has linked a card
        $stmt = $pdo->prepare("SELECT * FROM card_info WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $card = $stmt->fetch();
        
        if ($card) {
            echo "<p><strong>Card Number:</strong> **** **** **** " . substr($card['card_number'], -4) . "</p>";
            echo "<p><strong>Expiry Date:</strong> " . $card['expiry_date'] . "</p>";
            echo "<p><strong>Card Type:</strong> " . $card['card_type'] . "</p>";
        } else {
            echo "<button onclick='window.location.href=\"add_card.php\"'>Add Card Information</button>";
        }
        ?>
    </div>
</div>

<!-- Image Change Popup -->
<div id="imagePopup" class="image-popup">
    <div class="popup-content">
        <span class="close" onclick="closeImagePopup()">&times;</span>
        <h3>Change Profile Image</h3>
        <form action="update_profile_pic.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_pic" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
session_start();
require 'db_connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if user is not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the user's card information
$stmt = $pdo->prepare("SELECT * FROM card_info WHERE user_id = ?");
$stmt->execute([$user_id]);
$card_info = $stmt->fetch();

// Fetch all soup kitchens
$stmt = $pdo->prepare("SELECT * FROM soup_kitchens");
$stmt->execute();
$soup_kitchens = $stmt->fetchAll();

// Handle the donation form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $soup_kitchen_id = $_POST['soup_kitchen_id'];

    try {
        if (isset($_POST['money_donate']) && $card_info) { // Check if card information exists before allowing money donation
            $donation_amount = $_POST['donation_amount'];
            if ($donation_amount <= 0) {
                throw new Exception('Donation amount must be greater than zero.');
            }
            $points_earned = floor($donation_amount / 10);

            // Insert money donation
            $stmt = $pdo->prepare("INSERT INTO donations (user_id, soup_kitchen_id, donation_amount, donation_type) VALUES (?, ?, ?, 'money')");
            $stmt->execute([$user_id, $soup_kitchen_id, $donation_amount]);

            // Update user's score
            $stmt = $pdo->prepare("
                INSERT INTO scoreboard (user_id, score) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE score = score + VALUES(score)
            ");
            $stmt->execute([$user_id, $points_earned]);

        } elseif (isset($_POST['food_donate'])) { // Food Donation Form
            $food_quantity = $_POST['food_quantity'];
            $food_description = $_POST['food_description'];

            // Insert food donation
            $stmt = $pdo->prepare("INSERT INTO donations (user_id, soup_kitchen_id, food_quantity, food_description, donation_type) VALUES (?, ?, ?, ?, 'food')");
            $stmt->execute([$user_id, $soup_kitchen_id, $food_quantity, $food_description]);

            // Award fixed points for food donation
            $points_earned = 20;

            // Update user's score or insert a new record if the user_id doesn't exist
            $stmt = $pdo->prepare("
                INSERT INTO scoreboard (user_id, score) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE score = score + VALUES(score)
            ");
            $stmt->execute([$user_id, $points_earned]);
        }

        $message = "Thank you for your donation! You've earned points for your donation.";
        $message_type = 'success';

    } catch (Exception $e) {
        $message = "There was an error processing your donation. Please try again.";
        $message_type = 'error';
    }

    // Redirect with message
    header("Location: donate.php?message=$message&message_type=$message_type");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to a Soup Kitchen</title>
    <link rel="stylesheet" href="style.css">
</head>
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

<div class="container">
    <h1>Donate to a Soup Kitchen</h1>

    <!-- Display message after submission -->
    <?php if (isset($_GET['message'])): ?>
        <div class="message <?php echo $_GET['message_type']; ?>">
            <?php echo $_GET['message']; ?>
        </div>
    <?php endif; ?>

    <!-- Money Donation Form -->
    <h2>Money Donation</h2>
    <?php if ($card_info): ?>
        <form class="form-donate" method="POST" action="donate.php">
            <label for="soup_kitchen_id">Choose a Soup Kitchen:</label>
            <select name="soup_kitchen_id" required>
                <?php foreach ($soup_kitchens as $soup_kitchen): ?>
                    <option value="<?php echo $soup_kitchen['kitchen_id']; ?>"><?php echo htmlspecialchars($soup_kitchen['name']); ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="donation_amount">Donation Amount (in ZAR):</label>
            <input type="number" name="donation_amount" required min="1" step="0.01">

            <button type="submit" name="money_donate">Donate Money</button>
        </form>
    <?php else: ?>
        <p>You need to add your card information before donating money. Please update your profile with your card information.</p>
    <?php endif; ?>

    <!-- Food Donation Form -->
    <h2>Food Donation</h2>
    <form class="form-donate" method="POST" action="donate.php">
        <label for="soup_kitchen_id">Choose a Soup Kitchen:</label>
        <select name="soup_kitchen_id" required>
            <?php foreach ($soup_kitchens as $soup_kitchen): ?>
                <option value="<?php echo $soup_kitchen['kitchen_id']; ?>"><?php echo htmlspecialchars($soup_kitchen['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="food_quantity">Food Quantity:</label>
        <input type="number" name="food_quantity" required min="1">
        
        <label for="food_description">Food Description:</label>
        <textarea name="food_description" required></textarea>

        <button type="submit" name="food_donate">Donate Food</button>
    </form>
</div>
</body>
</html>

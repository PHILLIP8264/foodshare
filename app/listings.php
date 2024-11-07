<?php
session_start();
require 'db_connect.php';

$stmt = $pdo->query("SELECT l.listing_id, l.title, l.description, l.quantity, l.location, u.username AS donor FROM food_listings l JOIN users u ON l.user_id = u.user_id ORDER BY l.created_at DESC");
$listings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head><title>Food Listings</title></head>
<body>
<h1>Available Food Listings</h1>

<?php foreach ($listings as $listing): ?>
    <div class="listing">
        <h2><?php echo htmlspecialchars($listing['title']); ?></h2>
        <p><?php echo htmlspecialchars($listing['description']); ?></p>
        <p>Quantity: <?php echo htmlspecialchars($listing['quantity']); ?></p>
        <p>Location: <?php echo htmlspecialchars($listing['location']); ?></p>
        <p>Donated by: <?php echo htmlspecialchars($listing['donor']); ?></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="claim.php?listing_id=<?php echo $listing['listing_id']; ?>">Claim this item</a>
        <?php else: ?>
            <p><a href="login.php">Log in to claim items</a></p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>

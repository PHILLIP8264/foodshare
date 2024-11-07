<?php
session_start();
require 'db_connect.php';

// Fetch all soup kitchens from the database
$stmt = $pdo->prepare("SELECT * FROM soup_kitchens");
$stmt->execute();
$soup_kitchens = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodShare - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfsc7J32JsaPlUtdGJ0lOrKrXS8IWvanA&callback=initMap"></script>
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php"><img src="<?php echo $_SESSION['profile_pic']; ?>" class="profile-icon" alt="Profile" style="width 3px"></a></li>
            <li><a href="scoreboard.php">Scoreboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Hero Section -->
 <div class="hero-image">
    <div class="hero"> 
    <div class="hero-text">
        <h1>Donate to the need</h1>
        <a href="donate.php"><button>Donate</button></a>
    </div>
    </div>
</div>


<!-- Map Section -->
 <div class="map-container">
    <h1>Soup kitchens</h1>
    <div id="map" class="map-holder"></div>
 </div>


<script>
    function initMap() {
        var mapCenter = { lat: -25.7479, lng: 28.2293 }; // Example center coordinates (Pretoria, South Africa)
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: mapCenter
        });

        // Dynamically add soup kitchens from the database to the map
        var soupKitchens = <?php echo json_encode($soup_kitchens); ?>;

        soupKitchens.forEach(function(kitchen) {
            var location = { lat: parseFloat(kitchen.latitude), lng: parseFloat(kitchen.longitude) };
            new google.maps.Marker({
                position: location,
                map: map,
                title: kitchen.name // You can display the soup kitchen name when the user hovers over the marker
            });
        });
    }
</script>

</body>
</html>

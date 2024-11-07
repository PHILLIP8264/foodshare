<?php
session_start();
require 'db_connect.php'; // Make sure this points to the correct file for database connection

// Only allow logged-in users to view the scoreboard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Fetch top 10 users with their cumulative scores, ordered by total score
$stmt = $pdo->prepare("
    SELECT users.username, SUM(scoreboard.score) AS total_score 
    FROM scoreboard 
    JOIN users ON scoreboard.user_id = users.user_id 
    GROUP BY users.user_id 
    ORDER BY total_score DESC 
    LIMIT 10
");
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
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

<!-- Main Content -->
<div class="container">
    <h1>Scoreboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1;
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>" . htmlspecialchars($user['total_score']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

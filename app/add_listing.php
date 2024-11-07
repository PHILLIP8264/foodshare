<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO food_listings (user_id, title, description, quantity, location, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $quantity, $location, $latitude, $longitude]);

    header('Location: listings.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Listing</title></head>
<body>
<h1>Add Food Listing</h1>
<form method="POST">
    <label>Title:</label><input type="text" name="title" required><br>
    <label>Description:</label><textarea name="description" required></textarea><br>
    <label>Quantity:</label><input type="number" name="quantity" required><br>
    <label>Location:</label><input type="text" name="location" required><br>
    <label>Latitude:</label><input type="text" name="latitude" required><br>
    <label>Longitude:</label><input type="text" name="longitude" required><br>
    <button type="submit">Add Listing</button>
</form>
</body>
</html>

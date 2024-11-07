<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $card_type = $_POST['card_type'];
    
    // Store the card information in the database
    $stmt = $pdo->prepare("INSERT INTO card_info (user_id, card_number, expiry_date, card_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $card_number, $expiry_date, $card_type]);
    
    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Card Information</title>
</head>
<body>
    <h2>Add Card Information</h2>
    <form method="POST">
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" required><br>
        
        <label for="expiry_date">Expiry Date:</label>
        <input type="text" name="expiry_date" required><br>
        
        <label for="card_type">Card Type:</label>
        <input type="text" name="card_type" required><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>

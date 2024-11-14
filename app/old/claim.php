<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user has already claimed this listing
    $stmt = $pdo->prepare("SELECT * FROM claims WHERE listing_id = ? AND user_id = ?");
    $stmt->execute([$listing_id, $user_id]);
    if ($stmt->fetch()) {
        echo "You have already claimed this item.";
        exit;
    }

    // Insert claim into the claims table
    $stmt = $pdo->prepare("INSERT INTO claims (listing_id, user_id, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$listing_id, $user_id]);

    echo "Claim successful! Your request is pending approval.";
    header('Location: listings.php');
    exit;
} else {
    echo "No listing selected.";
    exit;
}
?>

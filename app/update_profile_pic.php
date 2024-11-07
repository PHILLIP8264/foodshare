<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Handle the image upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $image = $_FILES['profile_pic'];
        $imageName = $user_id . '_' . time() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $uploadDir = 'uploads/profile_pics/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uploadPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            // Update the user's profile picture path in the database
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE user_id = ?");
            $stmt->execute([$uploadPath, $user_id]);
            header('Location: profile.php');
        } else {
            echo "Error uploading the image.";
        }
    }
}
?>

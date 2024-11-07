<?php
$host = '/cloudsql/sanguine-fx-441010-h4:europe-west9:foodshareapp';
$dbname = 'foodshare';
$username = 'root';  // Update this if the username is different
$password = '4/bPV6Aoz"NlzTo9';  // Replace this with your actual password

try {
    $pdo = new PDO("mysql:unix_socket=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

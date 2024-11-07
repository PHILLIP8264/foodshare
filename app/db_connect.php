<?php
$host = '/cloudsql/YOUR_PROJECT_ID:sanguine-fx-441010-h4:europe-west9:foodshareapp';
$dbname = 'foodshare';
$username = 'root';
$password = '4/bPV6Aoz"NlzTo9';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<?php
session_start();
$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = ''; 
$db_name = 'neighborhood_help';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}


function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function current_user() {
    global $pdo;
    if (!empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT id,name,email,area,role FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

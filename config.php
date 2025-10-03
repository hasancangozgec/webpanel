<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'ko_server_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('SITE_URL', 'http://localhost/koserver');
define('SITE_NAME', 'KO Server Files');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch(PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

function cleanInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getUserIP() {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function jsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

function getContent($key, $default = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT content_value FROM site_content WHERE content_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['content_value'] : $default;
}

function updateContent($key, $value) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO site_content (content_key, content_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE content_value = ?");
    return $stmt->execute([$key, $value, $value]);
}
?>
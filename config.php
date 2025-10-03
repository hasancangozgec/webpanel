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
define('ADMIN_EMAIL', 'admin@koserver.com');

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
    try {
        $stmt = $pdo->prepare("SELECT content_value FROM site_content WHERE content_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['content_value'] : $default;
    } catch(PDOException $e) {
        return $default;
    }
}

function updateContent($key, $value) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            INSERT INTO site_content (content_key, content_value, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE content_value = ?, updated_at = NOW()
        ");
        return $stmt->execute([$key, $value, $value]);
    } catch(PDOException $e) {
        return false;
    }
}

function writeLog($message, $level = 'info') {
    $logFile = __DIR__ . '/logs/app.log';
    $logDir = dirname($logFile);
    
    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] [{$level}] {$message}\n";
    
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Rate limiting
function checkRateLimit($action, $limit = 5, $window = 60) {
    $ip = getUserIP();
    $key = "ratelimit_{$action}_{$ip}";
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'start' => time()];
    }
    
    $data = $_SESSION[$key];
    
    if (time() - $data['start'] > $window) {
        $_SESSION[$key] = ['count' => 1, 'start' => time()];
        return true;
    }
    
    if ($data['count'] >= $limit) {
        return false;
    }
    
    $_SESSION[$key]['count']++;
    return true;
}

function checkBruteForce($username) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as attempts 
            FROM login_attempts 
            WHERE username = ? 
            AND success = 0 
            AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        ");
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        
        $attempts = $result['attempts'];
        
        if ($attempts >= 5) {
            return [
                'blocked' => true,
                'remaining' => 15 - floor((time() - strtotime($result['attempted_at'])) / 60)
            ];
        }
        
        return ['blocked' => false];
    } catch(PDOException $e) {
        return ['blocked' => false];
    }
}

function recordLoginAttempt($username, $success) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO login_attempts (username, success, ip_address, attempted_at) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$username, $success ? 1 : 0, getUserIP()]);
    } catch(PDOException $e) {
        writeLog("Failed to record login attempt: " . $e->getMessage(), 'error');
    }
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// IP Whitelist
define('ADMIN_IP_WHITELIST', ['*']); // '*' = tüm IP'ler, belirli IP'ler için ['127.0.0.1', '192.168.1.1']
?>
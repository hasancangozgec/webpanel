<?php
/**
 * SECURE Admin Login Handler
 * Dosya: admin/admin_login.php
 * 
 * GÜVENLİK ÖZELLİKLERİ:
 * - Rate Limiting
 * - Brute Force Koruması
 * - CSRF Token (opsiyonel - JSON için)
 * - IP Whitelisting
 * - Session Hijacking Koruması
 * - Timing Attack Koruması
 */

require_once '../config.php';

// Security headers
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

// POST isteği kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek metodu');
}

// Rate Limiting kontrolü
checkRateLimit('admin_login');

// JSON data al ve validate et
$rawData = file_get_contents('php://input');
if (empty($rawData)) {
    jsonResponse(false, 'Boş istek');
}

try {
    $data = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    writeLog("Invalid JSON in login: " . $e->getMessage(), 'warning');
    jsonResponse(false, 'Geçersiz veri formatı');
}

// Input validation
$username = isset($data['username']) ? cleanInput($data['username']) : '';
$password = $data['password'] ?? ''; // Şifre temizlenmiyor (hash kontrolü için)

// Boş alan kontrolü
if (empty($username) || empty($password)) {
    writeLog("Empty login attempt from IP: " . getUserIP(), 'warning');
    jsonResponse(false, 'Kullanıcı adı ve şifre gerekli');
}

// Username formatı kontrolü (sadece alfanumerik ve _ -)
if (!preg_match('/^[a-zA-Z0-9_-]{3,50}$/', $username)) {
    writeLog("Invalid username format: {$username}", 'warning');
    jsonResponse(false, 'Geçersiz kullanıcı adı formatı');
}

// Şifre uzunluğu kontrolü
if (strlen($password) < 6 || strlen($password) > 255) {
    writeLog("Invalid password length for user: {$username}", 'warning');
    jsonResponse(false, 'Geçersiz şifre');
}

// Brute Force kontrolü
$bruteCheck = checkBruteForce($username);
if (is_array($bruteCheck) && $bruteCheck['blocked']) {
    writeLog("Brute force block active for: {$username}", 'warning');
    jsonResponse(false, "Çok fazla başarısız deneme. {$bruteCheck['remaining']} dakika bekleyin.");
}

try {
    // Kullanıcıyı veritabanından çek (Prepared Statement)
    $stmt = $pdo->prepare("
        SELECT id, username, email, password 
        FROM admin_users 
        WHERE username = ? 
        LIMIT 1
    ");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    // Timing attack'a karşı her durumda hash kontrolü yap
    $validPassword = false;
    if ($user) {
        $validPassword = verifyPassword($password, $user['password']);
    } else {
        // Kullanıcı yoksa bile timing'i aynı tut
        password_verify($password, '$2y$10$YOURfAkEhAsHhErEfOrTiMinGaTtAcKpRoTeCtIoN');
    }
    
    // Kullanıcı var ve şifre doğru mu?
    if ($user && $validPassword) {
        // IP kontrolü (Admin için)
        $userIP = getUserIP();
        if (!in_array($userIP, ADMIN_IP_WHITELIST) && !in_array('*', ADMIN_IP_WHITELIST)) {
            writeLog("Admin login from unauthorized IP: {$userIP} - User: {$username}", 'critical');
            recordLoginAttempt($username, false);
            jsonResponse(false, 'Bu IP adresinden admin girişi yapılamaz');
        }
        
        // Session'ı yenile (Session Fixation attack koruması)
        session_regenerate_id(true);
        
        // Oturum bilgilerini kaydet
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['login_time'] = time();
        $_SESSION['login_ip'] = $userIP;
        
        // Başarılı giriş kaydı
        recordLoginAttempt($username, true);
        writeLog("Successful admin login: {$username} from IP: {$userIP}", 'info');
        
        // Son giriş zamanını güncelle
        try {
            $pdo->prepare("
                INSERT INTO site_settings (setting_key, setting_value) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = NOW()
            ")->execute([
                'last_admin_login_' . $user['id'],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ]);
        } catch(PDOException $e) {
            writeLog("Failed to update last login: " . $e->getMessage(), 'error');
        }
        
        // Başarılı yanıt (hassas bilgi verme!)
        jsonResponse(true, 'Giriş başarılı', [
            'username' => cleanInput($user['username']),
            'redirect' => SITE_URL . '/admin/dashboard.php'
        ]);
        
    } else {
        // Hatalı giriş
        recordLoginAttempt($username, false);
        
        // Timing attack koruması için küçük gecikme
        usleep(rand(100000, 500000)); // 0.1-0.5 saniye
        
        writeLog("Failed login attempt: {$username} from IP: " . getUserIP(), 'warning');
        
        // Generic error message (kullanıcı adı mı şifre mi yanlış belli etme)
        jsonResponse(false, 'Kullanıcı adı veya şifre hatalı');
    }
    
} catch(PDOException $e) {
    // Veritabanı hatası (detay verme!)
    writeLog("Login database error: " . $e->getMessage(), 'critical');
    jsonResponse(false, 'Sistem hatası. Lütfen daha sonra tekrar deneyin.');
} catch(Exception $e) {
    // Genel hata
    writeLog("Login error: " . $e->getMessage(), 'error');
    jsonResponse(false, 'Bir hata oluştu');
}
?>
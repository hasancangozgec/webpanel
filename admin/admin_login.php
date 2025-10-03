<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$username = cleanInput($data['username'] ?? '');
$password = $data['password'] ?? '';

// TEST: Şifre kontrolünü geçici kaldır
if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_username'] = 'admin';
    jsonResponse(true, 'Test girişi başarılı');
}

jsonResponse(false, 'Hatalı giriş - username: ' . $username);
?>
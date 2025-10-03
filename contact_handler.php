<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$name = cleanInput($data['name'] ?? '');
$email = cleanInput($data['email'] ?? '');
$message = cleanInput($data['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    jsonResponse(false, 'Tüm alanları doldurun');
}

$stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message, ip_address) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $email, $message, getUserIP()]);

jsonResponse(true, 'Mesajınız gönderildi');
?>
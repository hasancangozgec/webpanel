<?php
require_once '../config.php';

if (!isAdmin()) {
    jsonResponse(false, 'Yetkisiz erişim');
}

try {
    // İletişim mesajı sayısı
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
    $messageCount = $stmt->fetch()['total'];
    
    // Toplam sipariş sayısı
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
    $orderCount = $stmt->fetch()['total'];
    
    $stats = [
        'messages' => $messageCount,
        'orders' => $orderCount
    ];
    
    jsonResponse(true, 'OK', $stats);
    
} catch(PDOException $e) {
    jsonResponse(false, 'Hata: ' . $e->getMessage());
}
?>
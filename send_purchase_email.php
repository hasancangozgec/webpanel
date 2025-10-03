<?php
/**
 * Email System - Purchase Notification
 * Dosya: send_purchase_email.php
 * Konum: C:\xampp\htdocs\koserver\send_purchase_email.php
 */

require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek');
}

$data = json_decode(file_get_contents('php://input'), true);

$customerName = cleanInput($data['name'] ?? '');
$customerEmail = cleanInput($data['email'] ?? '');
$amount = cleanInput($data['amount'] ?? '');

if (empty($customerName) || empty($customerEmail)) {
    jsonResponse(false, 'Eksik bilgi');
}

// Email gönderme fonksiyonu
function sendPurchaseEmail($name, $email, $amount) {
    $subject = "✅ Siparişiniz Alındı - KO Server Files";
    
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #ff6b35, #f7931e); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { display: inline-block; background: #ff6b35; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
            .info-box { background: white; padding: 20px; border-left: 4px solid #ff6b35; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>⚔️ KO Server Files</h1>
                <p>Siparişiniz için teşekkür ederiz!</p>
            </div>
            <div class='content'>
                <h2>Merhaba {$name},</h2>
                <p>Knight Online PVP sunucu dosyaları siparişiniz başarıyla alınmıştır.</p>
                
                <div class='info-box'>
                    <h3>📦 Sipariş Detayları:</h3>
                    <p><strong>Ürün:</strong> Premium Knight Online PVP Server Files</p>
                    <p><strong>Tutar:</strong> {$amount}</p>
                    <p><strong>Durum:</strong> ✅ Ödeme Alındı</p>
                    <p><strong>E-posta:</strong> {$email}</p>
                </div>
                
                <h3>📥 İndirme Linki:</h3>
                <p>Sunucu dosyalarınızı aşağıdaki linkten indirebilirsiniz:</p>
                <a href='https://yourdomain.com/download/server-files.zip' class='button'>📂 Dosyaları İndir</a>
                
                <h3>📖 Kurulum Rehberi:</h3>
                <p>Detaylı kurulum dökümanı:</p>
                <a href='https://yourdomain.com/docs/setup-guide.pdf' class='button'>📄 Rehberi İndir</a>
                
                <div class='info-box'>
                    <h3>🎁 Pakete Dahil:</h3>
                    <ul>
                        <li>✅ Tüm Kaynak Dosyalar</li>
                        <li>✅ Database Dosyaları</li>
                        <li>✅ Web Admin Paneli</li>
                        <li>✅ Video Kurulum Eğitimi</li>
                        <li>✅ 30 Gün Teknik Destek</li>
                        <li>✅ Lifetime Güncellemeler</li>
                    </ul>
                </div>
                
                <h3>📞 Destek:</h3>
                <p>Herhangi bir sorunuz olursa bizimle iletişime geçebilirsiniz:</p>
                <p>
                    📧 Email: info@koserverfiles.com<br>
                    💬 Discord: KOServerFiles#1234<br>
                    📱 Telefon: +90 555 123 4567<br>
                    ⏰ 7/24 Destek
                </p>
                
                <p><strong>Not:</strong> İndirme linki 48 saat boyunca geçerlidir.</p>
            </div>
            <div class='footer'>
                <p>&copy; 2024 KO Server Files. Tüm hakları saklıdır.</p>
                <p>Bu email otomatik olarak gönderilmiştir.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: KO Server Files <info@koserverfiles.com>" . "\r\n";
    $headers .= "Reply-To: info@koserverfiles.com" . "\r\n";
    
    // Email gönder
    $sent = mail($email, $subject, $message, $headers);
    
    if ($sent) {
        // Admin'e de bildirim gönder
        $adminSubject = "🎉 Yeni Sipariş - KO Server Files";
        $adminMessage = "
        Yeni bir sipariş alındı!
        
        Müşteri: {$name}
        Email: {$email}
        Tutar: {$amount}
        Tarih: " . date('Y-m-d H:i:s') . "
        IP: " . getUserIP() . "
        ";
        
        mail(ADMIN_EMAIL, $adminSubject, $adminMessage, $headers);
        
        // Veritabanına kaydet
        try {
            global $pdo;
            $stmt = $pdo->prepare("
                INSERT INTO orders (order_id, customer_name, email, amount, payment_status, files_sent, ip_address) 
                VALUES (?, ?, ?, ?, 'completed', TRUE, ?)
            ");
            $orderId = 'ORDER_' . time() . '_' . rand(1000, 9999);
            $stmt->execute([
                $orderId,
                $name,
                $email,
                str_replace(['₺', '.', ','], '', $amount),
                getUserIP()
            ]);
        } catch(PDOException $e) {
            writeLog("Order save error: " . $e->getMessage(), 'error');
        }
        
        return true;
    }
    
    return false;
}

// Email gönder
$result = sendPurchaseEmail($customerName, $customerEmail, $amount);

if ($result) {
    writeLog("Purchase email sent to: {$customerEmail}", 'info');
    jsonResponse(true, 'Email başarıyla gönderildi');
} else {
    writeLog("Purchase email failed: {$customerEmail}", 'error');
    jsonResponse(false, 'Email gönderilemedi');
}
?>
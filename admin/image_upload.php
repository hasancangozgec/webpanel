<?php
require_once '../config.php';

if (!isAdmin()) {
    jsonResponse(false, 'Yetkisiz');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek');
}

$uploadDir = '../uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Dosya tipi kontrolü
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed)) {
        jsonResponse(false, 'Sadece resim dosyaları yüklenebilir');
    }
    
    // Boyut kontrolü (5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        jsonResponse(false, 'Dosya çok büyük (Max 5MB)');
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        jsonResponse(true, 'Yüklendi', [
            'url' => 'uploads/' . $fileName,
            'filename' => $fileName
        ]);
    } else {
        jsonResponse(false, 'Yükleme hatası');
    }
} else {
    jsonResponse(false, 'Dosya seçilmedi');
}
?>
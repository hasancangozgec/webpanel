<?php
require_once '../config.php';

if (!isAdmin()) {
    jsonResponse(false, 'Yetkisiz');
}

$data = json_decode(file_get_contents('php://input'), true);
$filename = basename($data['filename'] ?? '');

if (empty($filename)) {
    jsonResponse(false, 'Dosya adı gerekli');
}

$filepath = '../uploads/' . $filename;

if (file_exists($filepath)) {
    if (unlink($filepath)) {
        jsonResponse(true, 'Silindi');
    } else {
        jsonResponse(false, 'Silinemedi');
    }
} else {
    jsonResponse(false, 'Dosya bulunamadı');
}
?>
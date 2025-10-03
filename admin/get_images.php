<?php
require_once '../config.php';

if (!isAdmin()) {
    jsonResponse(false, 'Yetkisiz');
}

$uploadDir = '../uploads/';
$images = [];

if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && !is_dir($uploadDir . $file)) {
            $images[] = [
                'filename' => $file,
                'url' => 'uploads/' . $file,
                'size' => filesize($uploadDir . $file),
                'date' => date('Y-m-d H:i', filemtime($uploadDir . $file))
            ];
        }
    }
}

jsonResponse(true, 'OK', $images);
?>
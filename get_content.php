<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

$content = [
    'home_title' => getContent('home_title', 'Premium KO Server'),
    'home_subtitle' => getContent('home_subtitle', 'Güvenli ve Optimize'),
    'server_price' => getContent('server_price', '2999'),
    'contact_email' => getContent('contact_email', 'info@koserver.com'),
    'contact_discord' => getContent('contact_discord', 'KOServer#1234'),
    'contact_phone' => getContent('contact_phone', '+90 555 123 4567'),
];

jsonResponse(true, 'OK', $content);
?>
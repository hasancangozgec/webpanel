<?php
require_once '../config.php';

if (!isAdmin()) {
    jsonResponse(false, 'Yetkisiz erişim');
}

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

try {
    switch ($action) {
        case 'update_home':
            updateContent('home_title', $data['title'] ?? '');
            updateContent('home_subtitle', $data['subtitle'] ?? '');
            if (isset($data['price'])) {
                updateContent('server_price', $data['price']);
            }
            jsonResponse(true, 'Ana sayfa güncellendi');
            break;
            
        case 'update_price':
            updateContent('server_price', $data['price'] ?? '');
            jsonResponse(true, 'Fiyat güncellendi');
            break;
            
        case 'update_contact':
            updateContent('contact_email', $data['email'] ?? '');
            updateContent('contact_discord', $data['discord'] ?? '');
            updateContent('contact_phone', $data['phone'] ?? '');
            jsonResponse(true, 'İletişim güncellendi');
            break;
            
        case 'update_colors':
            updateContent('primary_color', $data['primary'] ?? '#ff6b35');
            updateContent('secondary_color', $data['secondary'] ?? '#f7931e');
            jsonResponse(true, 'Renkler güncellendi');
            break;
            
        case 'update_logo':
            updateContent('logo_url', $data['logo_url'] ?? '');
            jsonResponse(true, 'Logo güncellendi');
            break;
            
        case 'update_hero_bg':
            updateContent('hero_bg', $data['bg_url'] ?? '');
            jsonResponse(true, 'Arka plan güncellendi');
            break;
            
        case 'update_features':
            $features = $data['features'] ?? [];
            updateContent('features_json', json_encode($features));
            jsonResponse(true, 'Özellikler güncellendi');
            break;
            
        case 'update_testimonials':
            $testimonials = $data['testimonials'] ?? [];
            updateContent('testimonials_json', json_encode($testimonials));
            jsonResponse(true, 'Yorumlar güncellendi');
            break;
            
        case 'update_footer':
            updateContent('footer_text', $data['footer_text'] ?? '');
            jsonResponse(true, 'Footer güncellendi');
            break;
            
        case 'update_social':
            updateContent('social_facebook', $data['facebook'] ?? '');
            updateContent('social_twitter', $data['twitter'] ?? '');
            updateContent('social_instagram', $data['instagram'] ?? '');
            updateContent('social_youtube', $data['youtube'] ?? '');
            jsonResponse(true, 'Sosyal medya güncellendi');
            break;
            
        case 'get_all_content':
            $content = [
                'home_title' => getContent('home_title', 'Knight Online Sunucu Dosyaları'),
                'home_subtitle' => getContent('home_subtitle', 'Güvenli ve Optimize'),
                'server_price' => getContent('server_price', '2999'),
                'contact_email' => getContent('contact_email', 'info@koserver.com'),
                'contact_discord' => getContent('contact_discord', 'KOServer#1234'),
                'contact_phone' => getContent('contact_phone', '+90 555 123 4567'),
                'logo_url' => getContent('logo_url', ''),
                'hero_bg' => getContent('hero_bg', ''),
                'primary_color' => getContent('primary_color', '#ff6b35'),
                'secondary_color' => getContent('secondary_color', '#f7931e'),
                'features' => json_decode(getContent('features_json', '[]'), true),
                'testimonials' => json_decode(getContent('testimonials_json', '[]'), true),
                'footer_text' => getContent('footer_text', '© 2024 KO Server'),
                'social' => [
                    'facebook' => getContent('social_facebook', ''),
                    'twitter' => getContent('social_twitter', ''),
                    'instagram' => getContent('social_instagram', ''),
                    'youtube' => getContent('social_youtube', '')
                ]
            ];
            jsonResponse(true, 'OK', $content);
            break;
            
        default:
            jsonResponse(false, 'Geçersiz işlem');
    }
} catch (Exception $e) {
    writeLog("Content update error: " . $e->getMessage(), 'error');
    jsonResponse(false, 'Hata: ' . $e->getMessage());
}
?>
<?php
require_once 'config.php';

// İçerikleri veritabanından çek
$homeTitle = getContent('home_title', 'Knight Online Sunucu Dosyaları');
$homeSubtitle = getContent('home_subtitle', 'Güvenli ve Optimize');
$serverPrice = getContent('server_price', '2999');
$contactEmail = getContent('contact_email', 'info@koserver.com');
$contactDiscord = getContent('contact_discord', 'KOServer#1234');
$contactPhone = getContent('contact_phone', '+90 555 123 4567');
$logoUrl = getContent('logo_url', '');
$heroBg = getContent('hero_bg', '');
$primaryColor = getContent('primary_color', '#ff6b35');
$secondaryColor = getContent('secondary_color', '#f7931e');
$footerText = getContent('footer_text', '© 2024 KO Server');

// JSON içerikleri
$features = json_decode(getContent('features_json', '[]'), true);
$testimonials = json_decode(getContent('testimonials_json', '[]'), true);

// Sosyal medya
$socialFacebook = getContent('social_facebook', '');
$socialTwitter = getContent('social_twitter', '');
$socialInstagram = getContent('social_instagram', '');
$socialYoutube = getContent('social_youtube', '');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($homeTitle); ?> - KO Server Files</title>
    <meta name="description" content="<?php echo htmlspecialchars($homeSubtitle); ?>">
    <style>
        :root {
            --primary-color: <?php echo $primaryColor; ?>;
            --secondary-color: <?php echo $secondaryColor; ?>;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            min-height: 100vh;
        }

        .header {
            background: rgba(0,0,0,0.9);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.5);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            list-style: none;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .content-area {
            padding: 2rem 1rem;
        }

        .hero {
            text-align: center;
            padding: 4rem 1rem;
            background: <?php echo $heroBg ? "url('" . htmlspecialchars($heroBg) . "') center/cover" : 'transparent'; ?>;
            background-blend-mode: overlay;
            border-radius: 20px;
            margin-bottom: 3rem;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            border-radius: 20px;
            z-index: 0;
        }

        .hero > * {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-button {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.2rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(255,107,53,0.4);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255,107,53,0.6);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .feature-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 10px 30px rgba(255,107,53,0.3);
        }

        .feature-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .feature-icon img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .feature-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 3rem 0;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255,107,53,0.2), rgba(247,147,30,0.2));
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(255,107,53,0.3);
        }

        .stat-number {
            font-size: 2.5rem;
            color: var(--primary-color);
            font-weight: bold;
        }

        .pricing-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,107,53,0.1));
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 30px;
            max-width: 600px;
            margin: 3rem auto;
            text-align: center;
            border: 2px solid var(--primary-color);
        }

        .price {
            font-size: 4rem;
            color: var(--primary-color);
            margin: 2rem 0;
            font-weight: bold;
        }

        .features-list {
            list-style: none;
            text-align: left;
            margin: 2rem 0;
        }

        .features-list li {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 1.1rem;
        }

        .features-list li:before {
            content: "✓ ";
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }

        .testimonials-section {
            margin: 4rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 3rem;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-info h4 {
            color: var(--primary-color);
        }

        .testimonial-rating {
            color: gold;
        }

        .contact-form {
            max-width: 600px;
            margin: 3rem auto;
            background: rgba(255,255,255,0.05);
            padding: 3rem;
            border-radius: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,107,53,0.3);
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .contact-info {
            text-align: center;
            margin-top: 3rem;
            font-size: 1.2rem;
        }

        .contact-info p {
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .social-links a {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }

        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 10px;
        }

        .alert-success {
            background: rgba(76,175,80,0.3);
            border-left: 4px solid #4caf50;
            color: #4caf50;
        }

        .alert-error {
            background: rgba(244,67,54,0.3);
            border-left: 4px solid #f44336;
            color: #f44336;
        }

        .hidden {
            display: none !important;
        }

        .footer {
            background: rgba(0,0,0,0.9);
            padding: 3rem 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                width: 100%;
                justify-content: center;
            }
            
            .hero {
                padding: 2rem 1rem;
            }

            .features-grid, .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav>
                <div class="logo">
                    <?php if ($logoUrl): ?>
                        <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo">
                    <?php else: ?>
                        ⚔️ KO SERVER
                    <?php endif; ?>
                </div>
                <ul class="nav-links">
                    <li><a href="#" onclick="showPage('home')">🏠 Ana Sayfa</a></li>
                    <li><a href="#" onclick="showPage('features')">⭐ Özellikler</a></li>
                    <li><a href="#" onclick="showPage('pricing')">💰 Fiyat</a></li>
                    <li><a href="#" onclick="showPage('testimonials')">💬 Yorumlar</a></li>
                    <li><a href="#" onclick="showPage('contact')">📞 İletişim</a></li>
                    <li><a href="admin/dashboard.php">🔐 Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="content-area">
            <!-- Ana Sayfa -->
            <div id="home-page" class="page-content">
                <section class="hero">
                    <h1><?php echo htmlspecialchars($homeTitle); ?></h1>
                    <p><?php echo htmlspecialchars($homeSubtitle); ?></p>
                    <button class="cta-button" onclick="showPage('pricing')">🚀 SATIN AL</button>
                </section>

                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div>Mutlu Müşteri</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">99.9%</div>
                        <div>Uptime Garantisi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div>Teknik Destek</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">100%</div>
                        <div>Güvenli</div>
                    </div>
                </div>

                <?php if (!empty($features)): ?>
                <div class="features-grid">
                    <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <?php if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $feature['icon'])): ?>
                                <img src="<?php echo htmlspecialchars($feature['icon']); ?>" alt="<?php echo htmlspecialchars($feature['title']); ?>">
                            <?php else: ?>
                                <?php echo $feature['icon']; ?>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($feature['title']); ?></h3>
                        <p><?php echo htmlspecialchars($feature['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Özellikler -->
            <div id="features-page" class="page-content hidden">
                <h1 class="section-title">🌟 Özelliklerimiz</h1>
                <?php if (!empty($features)): ?>
                <div class="features-grid">
                    <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <?php if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $feature['icon'])): ?>
                                <img src="<?php echo htmlspecialchars($feature['icon']); ?>" alt="<?php echo htmlspecialchars($feature['title']); ?>">
                            <?php else: ?>
                                <?php echo $feature['icon']; ?>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($feature['title']); ?></h3>
                        <p><?php echo htmlspecialchars($feature['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p style="text-align: center; opacity: 0.7;">Henüz özellik eklenmemiş.</p>
                <?php endif; ?>
            </div>

            <!-- Fiyatlandırma -->
            <div id="pricing-page" class="page-content hidden">
                <div class="pricing-card">
                    <h2>💎 Premium Paket</h2>
                    <div class="price">₺<?php echo number_format($serverPrice, 0, ',', '.'); ?></div>
                    <ul class="features-list">
                        <li>Tüm Kaynak Dosyalar</li>
                        <li>Database Dosyaları</li>
                        <li>Web Admin Paneli</li>
                        <li>Video Kurulum Rehberi</li>
                        <li>30 Gün Premium Destek</li>
                        <li>Ücretsiz Güncellemeler</li>
                        <li>7/24 Teknik Destek</li>
                        <li>Discord Topluluk Erişimi</li>
                    </ul>
                    <button class="cta-button" onclick="alert('İletişim formu üzerinden bizimle iletişime geçebilirsiniz!')">💳 SATIN AL</button>
                </div>
            </div>

            <!-- Yorumlar -->
            <div id="testimonials-page" class="page-content hidden">
                <h1 class="section-title">💬 Müşteri Yorumları</h1>
                <?php if (!empty($testimonials)): ?>
                <div class="testimonials-grid">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <?php if (!empty($testimonial['avatar'])): ?>
                                    <img src="<?php echo htmlspecialchars($testimonial['avatar']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>">
                                <?php else: ?>
                                    <?php echo mb_substr($testimonial['name'], 0, 1); ?>
                                <?php endif; ?>
                            </div>
                            <div class="testimonial-info">
                                <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                                <div class="testimonial-rating">
                                    <?php echo str_repeat('⭐', $testimonial['rating']); ?>
                                </div>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($testimonial['text']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p style="text-align: center; opacity: 0.7;">Henüz yorum eklenmemiş.</p>
                <?php endif; ?>
            </div>

            <!-- İletişim -->
            <div id="contact-page" class="page-content hidden">
                <h1 class="section-title">📞 İletişim</h1>
                <form class="contact-form" onsubmit="sendContactMessage(event)">
                    <div id="contact-alert"></div>
                    <div class="form-group">
                        <label>👤 İsim</label>
                        <input type="text" id="contact-name" required placeholder="Adınız Soyadınız">
                    </div>
                    <div class="form-group">
                        <label>📧 E-posta</label>
                        <input type="email" id="contact-email" required placeholder="ornek@email.com">
                    </div>
                    <div class="form-group">
                        <label>💬 Mesaj</label>
                        <textarea id="contact-message" required placeholder="Mesajınızı buraya yazın..."></textarea>
                    </div>
                    <button type="submit" class="cta-button" style="width:100%">📨 GÖNDER</button>
                </form>
                
                <div class="contact-info">
                    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">Bize Ulaşın</h3>
                    <p>📧 <?php echo htmlspecialchars($contactEmail); ?></p>
                    <p>💬 Discord: <?php echo htmlspecialchars($contactDiscord); ?></p>
                    <p>📱 <?php echo htmlspecialchars($contactPhone); ?></p>
                    
                    <?php if ($socialFacebook || $socialTwitter || $socialInstagram || $socialYoutube): ?>
                    <div class="social-links">
                        <?php if ($socialFacebook): ?>
                            <a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank" title="Facebook">📘</a>
                        <?php endif; ?>
                        <?php if ($socialTwitter): ?>
                            <a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank" title="Twitter">🐦</a>
                        <?php endif; ?>
                        <?php if ($socialInstagram): ?>
                            <a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank" title="Instagram">📷</a>
                        <?php endif; ?>
                        <?php if ($socialYoutube): ?>
                            <a href="<?php echo htmlspecialchars($socialYoutube); ?>" target="_blank" title="YouTube">📺</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p style="font-size: 1.2rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($footerText); ?></p>
            <?php if ($socialFacebook || $socialTwitter || $socialInstagram || $socialYoutube): ?>
            <div class="social-links">
                <?php if ($socialFacebook): ?>
                    <a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank">📘</a>
                <?php endif; ?>
                <?php if ($socialTwitter): ?>
                    <a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank">🐦</a>
                <?php endif; ?>
                <?php if ($socialInstagram): ?>
                    <a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank">📷</a>
                <?php endif; ?>
                <?php if ($socialYoutube): ?>
                    <a href="<?php echo htmlspecialchars($socialYoutube); ?>" target="_blank">📺</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </footer>

    <script>
        const API_URL = '<?php echo SITE_URL; ?>';

        function showPage(pageName) {
            document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
            document.getElementById(pageName + '-page').classList.remove('hidden');
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        function showAlert(id, msg, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = msg;
            
            const container = document.getElementById(id);
            container.innerHTML = '';
            container.appendChild(alertDiv);
            
            setTimeout(() => alertDiv.remove(), 5000);
        }

        async function sendContactMessage(e) {
            e.preventDefault();
            
            const data = {
                name: document.getElementById('contact-name').value,
                email: document.getElementById('contact-email').value,
                message: document.getElementById('contact-message').value
            };
            
            try {
                const res = await fetch(API_URL + '/contact_handler.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                showAlert('contact-alert', result.message, result.success ? 'success' : 'error');
                
                if(result.success) {
                    e.target.reset();
                }
            } catch(err) {
                showAlert('contact-alert', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            }
        }

        // Sayfa yüklendiğinde animasyonlar
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.feature-card, .testimonial-card, .stat-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            entry.target.style.transition = 'all 0.6s ease';
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, 100);
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => observer.observe(card));
        });
    </script>
</body>
</html>
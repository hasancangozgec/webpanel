<?php
require_once 'config.php';
$homeTitle = getContent('home_title', 'Knight Online Sunucu Dosyaları');
$homeSubtitle = getContent('home_subtitle', 'Güvenli ve Optimize');
$serverPrice = getContent('server_price', '2999');
$contactEmail = getContent('contact_email', 'info@koserver.com');
$contactDiscord = getContent('contact_discord', 'KOServer#1234');
$contactPhone = getContent('contact_phone', '+90 555 123 4567');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KO Server Files</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63);
            color: #fff;
            min-height: 100vh;
        }

        .header {
            background: rgba(0,0,0,0.8);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
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
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff6b35;
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
        }

        .content-area {
            padding: 2rem 1rem;
        }

        .hero {
            text-align: center;
            padding: 3rem 1rem;
        }

        .hero h1 {
            font-size: clamp(1.5rem, 5vw, 3rem);
            color: #ff6b35;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: clamp(1rem, 3vw, 1.3rem);
            margin-bottom: 2rem;
        }

        .cta-button {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            color: #ff6b35;
            font-weight: bold;
        }

        .pricing-card {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 20px;
            max-width: 500px;
            margin: 2rem auto;
            text-align: center;
        }

        .price {
            font-size: 3rem;
            color: #ff6b35;
            margin: 1rem 0;
        }

        .features-list {
            list-style: none;
            text-align: left;
            margin: 2rem 0;
        }

        .features-list li {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .features-list li:before {
            content: "✓ ";
            color: #ff6b35;
        }

        .contact-form {
            max-width: 600px;
            margin: 2rem auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ff6b35;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,107,53,0.3);
            border-radius: 8px;
            color: #fff;
        }

        .form-group textarea {
            min-height: 150px;
        }

        .admin-login {
            max-width: 400px;
            margin: 3rem auto;
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 20px;
        }

        .admin-panel {
            display: none;
        }

        .admin-panel.active {
            display: block;
        }

        .admin-section {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .save-button {
            background: #4caf50;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 8px;
        }

        .alert-success {
            background: rgba(76,175,80,0.3);
            color: #4caf50;
        }

        .alert-error {
            background: rgba(244,67,54,0.3);
            color: #f44336;
        }

        .hidden {
            display: none !important;
        }

        .footer {
            background: rgba(0,0,0,0.8);
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                width: 100%;
                justify-content: center;
            }
            
            .hero {
                padding: 2rem 0.5rem;
            }

            .features-grid {
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
                <div class="logo">⚔️ KO SERVER</div>
                <ul class="nav-links">
                    <li><a href="#" onclick="showPage('home')">Ana Sayfa</a></li>
                    <li><a href="#" onclick="showPage('features')">Özellikler</a></li>
                    <li><a href="#" onclick="showPage('pricing')">Fiyat</a></li>
                    <li><a href="#" onclick="showPage('contact')">İletişim</a></li>
                    <li><a href="#" onclick="showPage('admin')">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="content-area">
            <!-- Ana Sayfa -->
            <div id="home-page" class="page-content">
                <section class="hero">
                    <h1 id="main-title"><?php echo $homeTitle; ?></h1>
                    <p id="main-subtitle"><?php echo $homeSubtitle; ?></p>
                    <button class="cta-button" onclick="showPage('pricing')">🚀 SATIN AL</button>
                </section>

                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div>Müşteri</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">99.9%</div>
                        <div>Uptime</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div>Destek</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">100%</div>
                        <div>Güvenli</div>
                    </div>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🛡️</div>
                        <h3>Güvenlik</h3>
                        <p>En son güvenlik yamaları</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3>Performans</h3>
                        <p>Optimize edilmiş kodlar</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🎮</div>
                        <h3>PVP</h3>
                        <p>Dengeli savaş sistemi</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🔧</div>
                        <h3>Kurulum</h3>
                        <p>Kolay ve hızlı</p>
                    </div>
                </div>
            </div>

            <!-- Özellikler -->
            <div id="features-page" class="page-content hidden">
                <h1>Özellikler</h1>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>⚔️ PVP Sistemi</h3>
                        <p>Dengeli savaş mekaniği</p>
                    </div>
                    <div class="feature-card">
                        <h3>💎 Item Sistemi</h3>
                        <p>Özelleştirilebilir itemler</p>
                    </div>
                    <div class="feature-card">
                        <h3>🏰 Castle Siege</h3>
                        <p>Kale savaşları</p>
                    </div>
                    <div class="feature-card">
                        <h3>📊 Admin Panel</h3>
                        <p>Web yönetim paneli</p>
                    </div>
                </div>
            </div>

            <!-- Fiyatlandırma -->
            <div id="pricing-page" class="page-content hidden">
                <div class="pricing-card">
                    <h2>Premium Paket</h2>
                    <div class="price" id="server-price">₺<?php echo number_format($serverPrice, 0, ',', '.'); ?></div>
                    <ul class="features-list">
                        <li>Tüm Kaynak Dosyalar</li>
                        <li>Database Dosyaları</li>
                        <li>Admin Paneli</li>
                        <li>Kurulum Rehberi</li>
                        <li>30 Gün Destek</li>
                        <li>Ücretsiz Güncellemeler</li>
                    </ul>
                    <button class="cta-button">SATIN AL</button>
                </div>
            </div>

            <!-- İletişim -->
            <div id="contact-page" class="page-content hidden">
                <h1 style="text-align:center">İletişim</h1>
                <form class="contact-form" onsubmit="sendContactMessage(event)">
                    <div id="contact-alert"></div>
                    <div class="form-group">
                        <label>İsim</label>
                        <input type="text" id="contact-name" required>
                    </div>
                    <div class="form-group">
                        <label>E-posta</label>
                        <input type="email" id="contact-email" required>
                    </div>
                    <div class="form-group">
                        <label>Mesaj</label>
                        <textarea id="contact-message" required></textarea>
                    </div>
                    <button type="submit" class="cta-button" style="width:100%">GÖNDER</button>
                </form>
                <div style="text-align:center; margin-top:2rem">
                    <p>📧 <?php echo $contactEmail; ?></p>
                    <p>💬 <?php echo $contactDiscord; ?></p>
                    <p>📱 <?php echo $contactPhone; ?></p>
                </div>
            </div>

            <!-- Admin -->
            <div id="admin-page" class="page-content hidden">
                <div id="admin-login" class="admin-login">
                    <h2 style="text-align:center; color:#ff6b35">Admin Girişi</h2>
                    <div id="admin-alert"></div>
                    <form onsubmit="adminLogin(event)">
                        <div class="form-group">
                            <label>Kullanıcı Adı</label>
                            <input type="text" id="admin-username" required>
                        </div>
                        <div class="form-group">
                            <label>Şifre</label>
                            <input type="password" id="admin-password" required>
                        </div>
                        <button type="submit" class="cta-button" style="width:100%">GİRİŞ</button>
                    </form>
                </div>

                <div id="admin-panel" class="admin-panel">
                    <h1 style="color:#ff6b35">Yönetim Paneli</h1>
                    
                    <div class="admin-section">
                        <h3>Ana Sayfa</h3>
                        <div class="form-group">
                            <label>Başlık</label>
                            <input type="text" id="edit-main-title" value="<?php echo $homeTitle; ?>">
                        </div>
                        <div class="form-group">
                            <label>Alt Başlık</label>
                            <input type="text" id="edit-main-subtitle" value="<?php echo $homeSubtitle; ?>">
                        </div>
                        <button class="save-button" onclick="saveHomeContent()">KAYDET</button>
                    </div>

                    <div class="admin-section">
                        <h3>Fiyat</h3>
                        <div class="form-group">
                            <label>Fiyat (₺)</label>
                            <input type="number" id="edit-price" value="<?php echo $serverPrice; ?>">
                        </div>
                        <button class="save-button" onclick="savePrice()">GÜNCELLE</button>
                    </div>

                    <div class="admin-section">
                        <h3>İletişim</h3>
                        <div class="form-group">
                            <label>E-posta</label>
                            <input type="email" id="edit-email" value="<?php echo $contactEmail; ?>">
                        </div>
                        <div class="form-group">
                            <label>Discord</label>
                            <input type="text" id="edit-discord" value="<?php echo $contactDiscord; ?>">
                        </div>
                        <div class="form-group">
                            <label>Telefon</label>
                            <input type="text" id="edit-phone" value="<?php echo $contactPhone; ?>">
                        </div>
                        <button class="save-button" onclick="saveContact()">KAYDET</button>
                    </div>

                    <button class="cta-button" onclick="adminLogout()">ÇIKIŞ</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 KO Server Files</p>
    </footer>

    <script>
        const API_URL = '<?php echo SITE_URL; ?>';

        function showPage(pageName) {
            document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
            document.getElementById(pageName + '-page').classList.remove('hidden');
            window.scrollTo(0, 0);
        }

        function showAlert(id, msg, type) {
            document.getElementById(id).innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
            setTimeout(() => document.getElementById(id).innerHTML = '', 3000);
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
                if(result.success) e.target.reset();
            } catch(err) {
                showAlert('contact-alert', 'Hata oluştu', 'error');
            }
        }

        async function adminLogin(e) {
            e.preventDefault();
            const data = {
                username: document.getElementById('admin-username').value,
                password: document.getElementById('admin-password').value
            };
            
            try {
                const res = await fetch(API_URL + '/admin/admin_login.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                if(result.success) {
                    document.getElementById('admin-login').style.display = 'none';
                    document.getElementById('admin-panel').classList.add('active');
                } else {
                    showAlert('admin-alert', result.message, 'error');
                }
            } catch(err) {
                showAlert('admin-alert', 'Giriş hatası', 'error');
            }
        }

        function adminLogout() {
            document.getElementById('admin-login').style.display = 'block';
            document.getElementById('admin-panel').classList.remove('active');
        }

        async function saveHomeContent() {
            const data = {
                action: 'update_home',
                title: document.getElementById('edit-main-title').value,
                subtitle: document.getElementById('edit-main-subtitle').value
            };
            
            const res = await fetch(API_URL + '/admin/update_content.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await res.json();
            alert(result.message);
            if(result.success) location.reload();
        }

        async function savePrice() {
            const data = {
                action: 'update_price',
                price: document.getElementById('edit-price').value
            };
            
            const res = await fetch(API_URL + '/admin/update_content.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await res.json();
            alert(result.message);
            if(result.success) location.reload();
        }

        async function saveContact() {
            const data = {
                action: 'update_contact',
                email: document.getElementById('edit-email').value,
                discord: document.getElementById('edit-discord').value,
                phone: document.getElementById('edit-phone').value
            };
            
            const res = await fetch(API_URL + '/admin/update_content.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await res.json();
            alert(result.message);
            if(result.success) location.reload();
        }
    </script>
</body>
</html>
<?php
require_once '../config.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - KO Server</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            min-height: 100vh;
        }

        .admin-header {
            background: rgba(0,0,0,0.9);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .admin-header h1 {
            color: #ff6b35;
            font-size: 1.5rem;
        }

        .logout-btn {
            background: #f44336;
            color: white;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .admin-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 1rem 2rem;
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 10px 10px 0 0;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .tab-btn:hover {
            background: rgba(255,107,53,0.3);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
        }

        .tab-content {
            display: none;
            background: rgba(255,255,255,0.05);
            padding: 2rem;
            border-radius: 0 10px 10px 10px;
            backdrop-filter: blur(10px);
        }

        .tab-content.active {
            display: block;
        }

        .form-section {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .form-section h3 {
            color: #ff6b35;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ffa726;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,107,53,0.3);
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .save-btn {
            background: linear-gradient(135deg, #4caf50, #45a049);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76,175,80,0.4);
        }

        .image-upload-area {
            border: 2px dashed rgba(255,107,53,0.5);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload-area:hover {
            border-color: #ff6b35;
            background: rgba(255,107,53,0.1);
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .image-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255,255,255,0.1);
            padding: 0.5rem;
        }

        .image-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .image-item .image-info {
            padding: 0.5rem;
            font-size: 0.85rem;
        }

        .image-item .image-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .btn-use, .btn-delete {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-use {
            background: #2196f3;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .color-picker-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .color-preview {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .features-editor, .testimonials-editor {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .feature-item, .testimonial-item {
            background: rgba(255,255,255,0.08);
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #ff6b35;
        }

        .item-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #2196f3, #1976d2);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .btn-remove {
            background: #f44336;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            animation: slideIn 0.3s;
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

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255,107,53,0.2), rgba(247,147,30,0.2));
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #ff6b35;
        }

        .stat-label {
            margin-top: 0.5rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 1rem;
            }

            .tabs {
                flex-direction: column;
            }

            .tab-btn {
                width: 100%;
            }

            .form-section {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>⚔️ KO Server - Admin Panel</h1>
        <div>
            <span style="margin-right: 1rem;">👋 Hoş geldin, <?php echo $_SESSION['admin_username']; ?></span>
            <a href="logout.php" class="logout-btn">🚪 Çıkış</a>
        </div>
    </header>

    <div class="admin-container">
        <div id="alert-container"></div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" id="total-images">0</div>
                <div class="stat-label">📸 Toplam Resim</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="total-messages">0</div>
                <div class="stat-label">✉️ İletişim Mesajı</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="total-features">0</div>
                <div class="stat-label">⭐ Özellik</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="total-testimonials">0</div>
                <div class="stat-label">💬 Yorum</div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('home')">🏠 Ana Sayfa</button>
            <button class="tab-btn" onclick="switchTab('images')">🖼️ Resim Yönetimi</button>
            <button class="tab-btn" onclick="switchTab('features')">⭐ Özellikler</button>
            <button class="tab-btn" onclick="switchTab('testimonials')">💬 Yorumlar</button>
            <button class="tab-btn" onclick="switchTab('colors')">🎨 Renkler</button>
            <button class="tab-btn" onclick="switchTab('contact')">📞 İletişim</button>
            <button class="tab-btn" onclick="switchTab('social')">🌐 Sosyal Medya</button>
        </div>

        <!-- ANA SAYFA -->
        <div id="home-tab" class="tab-content active">
            <div class="form-section">
                <h3>🏠 Ana Sayfa Ayarları</h3>
                <div class="form-group">
                    <label>Başlık</label>
                    <input type="text" id="home-title" placeholder="Knight Online Sunucu Dosyaları">
                </div>
                <div class="form-group">
                    <label>Alt Başlık</label>
                    <input type="text" id="home-subtitle" placeholder="Güvenli ve Optimize">
                </div>
                <div class="form-group">
                    <label>Sunucu Fiyatı (₺)</label>
                    <input type="number" id="server-price" placeholder="2999">
                </div>
                <button class="save-btn" onclick="saveHomeSettings()">💾 Kaydet</button>
            </div>

            <div class="form-section">
                <h3>🎨 Logo ve Arka Plan</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Logo URL</label>
                        <input type="text" id="logo-url" placeholder="uploads/logo.png">
                    </div>
                    <div class="form-group">
                        <label>Hero Arka Plan URL</label>
                        <input type="text" id="hero-bg" placeholder="uploads/hero-bg.jpg">
                    </div>
                </div>
                <button class="save-btn" onclick="saveVisuals()">💾 Görselleri Kaydet</button>
            </div>
        </div>

        <!-- RESİM YÖNETİMİ -->
        <div id="images-tab" class="tab-content">
            <div class="form-section">
                <h3>📤 Resim Yükle</h3>
                <div class="image-upload-area" onclick="document.getElementById('file-input').click()">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">📁</p>
                    <p>Tıklayın veya sürükleyip bırakın</p>
                    <p style="font-size: 0.85rem; opacity: 0.7; margin-top: 0.5rem;">JPG, PNG, GIF, WEBP (Max 5MB)</p>
                </div>
                <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="uploadImage(this)">
            </div>

            <div class="form-section">
                <h3>🖼️ Yüklü Resimler</h3>
                <div class="image-gallery" id="image-gallery"></div>
            </div>
        </div>

        <!-- ÖZELLİKLER -->
        <div id="features-tab" class="tab-content">
            <div class="form-section">
                <h3>⭐ Özellikler Yönetimi</h3>
                <button class="btn-add" onclick="addFeature()">➕ Yeni Özellik Ekle</button>
                <div class="features-editor" id="features-editor"></div>
                <button class="save-btn" onclick="saveFeatures()">💾 Özellikleri Kaydet</button>
            </div>
        </div>

        <!-- YORUMLAR -->
        <div id="testimonials-tab" class="tab-content">
            <div class="form-section">
                <h3>💬 Müşteri Yorumları</h3>
                <button class="btn-add" onclick="addTestimonial()">➕ Yeni Yorum Ekle</button>
                <div class="testimonials-editor" id="testimonials-editor"></div>
                <button class="save-btn" onclick="saveTestimonials()">💾 Yorumları Kaydet</button>
            </div>
        </div>

        <!-- RENKLER -->
        <div id="colors-tab" class="tab-content">
            <div class="form-section">
                <h3>🎨 Tema Renkleri</h3>
                <div class="form-group">
                    <label>Birincil Renk</label>
                    <div class="color-picker-group">
                        <input type="color" id="primary-color" value="#ff6b35">
                        <input type="text" id="primary-color-text" value="#ff6b35">
                        <div class="color-preview" id="primary-preview"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>İkincil Renk</label>
                    <div class="color-picker-group">
                        <input type="color" id="secondary-color" value="#f7931e">
                        <input type="text" id="secondary-color-text" value="#f7931e">
                        <div class="color-preview" id="secondary-preview"></div>
                    </div>
                </div>
                <button class="save-btn" onclick="saveColors()">💾 Renkleri Kaydet</button>
            </div>
        </div>

        <!-- İLETİŞİM -->
        <div id="contact-tab" class="tab-content">
            <div class="form-section">
                <h3>📞 İletişim Bilgileri</h3>
                <div class="form-group">
                    <label>📧 E-posta</label>
                    <input type="email" id="contact-email" placeholder="info@koserver.com">
                </div>
                <div class="form-group">
                    <label>💬 Discord</label>
                    <input type="text" id="contact-discord" placeholder="KOServer#1234">
                </div>
                <div class="form-group">
                    <label>📱 Telefon</label>
                    <input type="text" id="contact-phone" placeholder="+90 555 123 4567">
                </div>
                <div class="form-group">
                    <label>📝 Footer Metni</label>
                    <input type="text" id="footer-text" placeholder="© 2024 KO Server">
                </div>
                <button class="save-btn" onclick="saveContact()">💾 İletişim Bilgilerini Kaydet</button>
            </div>
        </div>

        <!-- SOSYAL MEDYA -->
        <div id="social-tab" class="tab-content">
            <div class="form-section">
                <h3>🌐 Sosyal Medya Linkleri</h3>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" id="social-facebook" placeholder="https://facebook.com/koserver">
                </div>
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="url" id="social-twitter" placeholder="https://twitter.com/koserver">
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="url" id="social-instagram" placeholder="https://instagram.com/koserver">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="url" id="social-youtube" placeholder="https://youtube.com/@koserver">
                </div>
                <button class="save-btn" onclick="saveSocial()">💾 Sosyal Medyayı Kaydet</button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '<?php echo SITE_URL; ?>';
        let currentContent = {};

        // Sayfa yüklendiğinde tüm içeriği çek
        document.addEventListener('DOMContentLoaded', () => {
            loadAllContent();
            loadImages();
            setupColorPickers();
            loadStats();
        });
        
        async function loadStats() {
            try {
                const res = await fetch(`${API_URL}/admin/get_stats.php`);
                const result = await res.json();
                
                if (result.success) {
                    document.getElementById('total-messages').textContent = result.data.messages;
                }
            } catch(err) {
                console.error('İstatistikler yüklenemedi:', err);
            }
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            event.target.classList.add('active');
            document.getElementById(tabName + '-tab').classList.add('active');
        }

        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            
            const container = document.getElementById('alert-container');
            container.appendChild(alertDiv);
            
            setTimeout(() => alertDiv.remove(), 5000);
        }

        async function loadAllContent() {
            try {
                const res = await fetch(`${API_URL}/admin/update_content.php`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({action: 'get_all_content'})
                });
                const result = await res.json();
                
                if (result.success) {
                    currentContent = result.data;
                    populateFields();
                }
            } catch(err) {
                showAlert('İçerik yüklenemedi', 'error');
            }
        }

        function populateFields() {
            // Ana sayfa
            document.getElementById('home-title').value = currentContent.home_title || '';
            document.getElementById('home-subtitle').value = currentContent.home_subtitle || '';
            document.getElementById('server-price').value = currentContent.server_price || '';
            document.getElementById('logo-url').value = currentContent.logo_url || '';
            document.getElementById('hero-bg').value = currentContent.hero_bg || '';
            
            // Renkler
            document.getElementById('primary-color').value = currentContent.primary_color || '#ff6b35';
            document.getElementById('primary-color-text').value = currentContent.primary_color || '#ff6b35';
            document.getElementById('secondary-color').value = currentContent.secondary_color || '#f7931e';
            document.getElementById('secondary-color-text').value = currentContent.secondary_color || '#f7931e';
            
            // İletişim
            document.getElementById('contact-email').value = currentContent.contact_email || '';
            document.getElementById('contact-discord').value = currentContent.contact_discord || '';
            document.getElementById('contact-phone').value = currentContent.contact_phone || '';
            document.getElementById('footer-text').value = currentContent.footer_text || '';
            
            // Sosyal medya
            if (currentContent.social) {
                document.getElementById('social-facebook').value = currentContent.social.facebook || '';
                document.getElementById('social-twitter').value = currentContent.social.twitter || '';
                document.getElementById('social-instagram').value = currentContent.social.instagram || '';
                document.getElementById('social-youtube').value = currentContent.social.youtube || '';
            }
            
            // Özellikler
            loadFeatures(currentContent.features || []);
            
            // Yorumlar
            loadTestimonials(currentContent.testimonials || []);
            
            // İstatistikleri güncelle
            updateStats();
        }

        function setupColorPickers() {
            const primaryColor = document.getElementById('primary-color');
            const primaryText = document.getElementById('primary-color-text');
            const secondaryColor = document.getElementById('secondary-color');
            const secondaryText = document.getElementById('secondary-color-text');
            
            primaryColor.addEventListener('input', (e) => {
                primaryText.value = e.target.value;
                document.getElementById('primary-preview').style.background = e.target.value;
            });
            
            primaryText.addEventListener('input', (e) => {
                primaryColor.value = e.target.value;
                document.getElementById('primary-preview').style.background = e.target.value;
            });
            
            secondaryColor.addEventListener('input', (e) => {
                secondaryText.value = e.target.value;
                document.getElementById('secondary-preview').style.background = e.target.value;
            });
            
            secondaryText.addEventListener('input', (e) => {
                secondaryColor.value = e.target.value;
                document.getElementById('secondary-preview').style.background = e.target.value;
            });
        }

        async function saveHomeSettings() {
            const data = {
                action: 'update_home',
                title: document.getElementById('home-title').value,
                subtitle: document.getElementById('home-subtitle').value,
                price: document.getElementById('server-price').value
            };
            
            await saveData(data, 'Ana sayfa güncellendi');
        }

        async function saveVisuals() {
            const logoData = {
                action: 'update_logo',
                logo_url: document.getElementById('logo-url').value
            };
            
            const bgData = {
                action: 'update_hero_bg',
                bg_url: document.getElementById('hero-bg').value
            };
            
            await saveData(logoData);
            await saveData(bgData, 'Görseller güncellendi');
        }

        async function saveColors() {
            const data = {
                action: 'update_colors',
                primary: document.getElementById('primary-color').value,
                secondary: document.getElementById('secondary-color').value
            };
            
            await saveData(data, 'Renkler güncellendi');
        }

        async function saveContact() {
            const data = {
                action: 'update_contact',
                email: document.getElementById('contact-email').value,
                discord: document.getElementById('contact-discord').value,
                phone: document.getElementById('contact-phone').value
            };
            
            const footerData = {
                action: 'update_footer',
                footer_text: document.getElementById('footer-text').value
            };
            
            await saveData(data);
            await saveData(footerData, 'İletişim bilgileri güncellendi');
        }

        async function saveSocial() {
            const data = {
                action: 'update_social',
                facebook: document.getElementById('social-facebook').value,
                twitter: document.getElementById('social-twitter').value,
                instagram: document.getElementById('social-instagram').value,
                youtube: document.getElementById('social-youtube').value
            };
            
            await saveData(data, 'Sosyal medya güncellendi');
        }

        async function saveData(data, successMsg = 'Kaydedildi') {
            try {
                const res = await fetch(`${API_URL}/admin/update_content.php`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                
                if (result.success) {
                    showAlert(successMsg);
                } else {
                    showAlert(result.message, 'error');
                }
            } catch(err) {
                showAlert('Kaydetme hatası', 'error');
            }
        }

        // RESİM YÖNETİMİ
        async function loadImages() {
            try {
                const res = await fetch(`${API_URL}/admin/get_images.php`);
                const result = await res.json();
                
                if (result.success) {
                    displayImages(result.data);
                }
            } catch(err) {
                console.error('Resimler yüklenemedi:', err);
            }
        }

        function displayImages(images) {
            const gallery = document.getElementById('image-gallery');
            gallery.innerHTML = '';
            
            images.forEach(img => {
                const div = document.createElement('div');
                div.className = 'image-item';
                div.innerHTML = `
                    <img src="${API_URL}/${img.url}" alt="${img.filename}">
                    <div class="image-info">
                        <strong>${img.filename}</strong><br>
                        <small>${(img.size / 1024).toFixed(2)} KB</small><br>
                        <small>${img.date}</small>
                    </div>
                    <div class="image-actions">
                        <button class="btn-use" onclick="copyImagePath('${img.url}')">📋 Kopyala</button>
                        <button class="btn-delete" onclick="deleteImage('${img.filename}')">🗑️ Sil</button>
                    </div>
                `;
                gallery.appendChild(div);
            });
            
            document.getElementById('total-images').textContent = images.length;
        }

        async function uploadImage(input) {
            if (!input.files || !input.files[0]) return;
            
            const formData = new FormData();
            formData.append('image', input.files[0]);
            
            try {
                const res = await fetch(`${API_URL}/admin/image_upload.php`, {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                
                if (result.success) {
                    showAlert('Resim yüklendi');
                    loadImages();
                } else {
                    showAlert(result.message, 'error');
                }
            } catch(err) {
                showAlert('Yükleme hatası', 'error');
            }
            
            input.value = '';
        }

        function copyImagePath(url) {
            navigator.clipboard.writeText(url);
            showAlert('Resim yolu kopyalandı');
        }

        async function deleteImage(filename) {
            if (!confirm('Bu resmi silmek istediğinize emin misiniz?')) return;
            
            try {
                const res = await fetch(`${API_URL}/admin/delete_image.php`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({filename})
                });
                const result = await res.json();
                
                if (result.success) {
                    showAlert('Resim silindi');
                    loadImages();
                } else {
                    showAlert(result.message, 'error');
                }
            } catch(err) {
                showAlert('Silme hatası', 'error');
            }
        }

        // ÖZELLİKLER YÖNETİMİ
        function loadFeatures(features) {
            const editor = document.getElementById('features-editor');
            editor.innerHTML = '';
            
            features.forEach((feature, index) => {
                const div = document.createElement('div');
                div.className = 'feature-item';
                div.innerHTML = `
                    <div class="form-group">
                        <label>İkon (Emoji veya URL)</label>
                        <input type="text" id="feature-icon-${index}" value="${feature.icon || '⭐'}" placeholder="🎮">
                    </div>
                    <div class="form-group">
                        <label>Başlık</label>
                        <input type="text" id="feature-title-${index}" value="${feature.title || ''}" placeholder="Özellik Başlığı">
                    </div>
                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea id="feature-desc-${index}" placeholder="Özellik açıklaması">${feature.description || ''}</textarea>
                    </div>
                    <div class="item-actions">
                        <button class="btn-remove" onclick="removeFeature(${index})">🗑️ Kaldır</button>
                    </div>
                `;
                editor.appendChild(div);
            });
            
            document.getElementById('total-features').textContent = features.length;
        }

        function addFeature() {
            const editor = document.getElementById('features-editor');
            const index = editor.children.length;
            
            const div = document.createElement('div');
            div.className = 'feature-item';
            div.innerHTML = `
                <div class="form-group">
                    <label>İkon (Emoji veya URL)</label>
                    <input type="text" id="feature-icon-${index}" value="⭐" placeholder="🎮">
                </div>
                <div class="form-group">
                    <label>Başlık</label>
                    <input type="text" id="feature-title-${index}" placeholder="Özellik Başlığı">
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea id="feature-desc-${index}" placeholder="Özellik açıklaması"></textarea>
                </div>
                <div class="item-actions">
                    <button class="btn-remove" onclick="removeFeature(${index})">🗑️ Kaldır</button>
                </div>
            `;
            editor.appendChild(div);
        }

        function removeFeature(index) {
            const editor = document.getElementById('features-editor');
            editor.children[index].remove();
            
            // Indexleri yeniden düzenle
            Array.from(editor.children).forEach((child, newIndex) => {
                child.querySelectorAll('input, textarea').forEach(input => {
                    input.id = input.id.replace(/\d+$/, newIndex);
                });
                child.querySelector('.btn-remove').onclick = () => removeFeature(newIndex);
            });
        }

        async function saveFeatures() {
            const editor = document.getElementById('features-editor');
            const features = [];
            
            Array.from(editor.children).forEach((child, index) => {
                const icon = document.getElementById(`feature-icon-${index}`).value;
                const title = document.getElementById(`feature-title-${index}`).value;
                const description = document.getElementById(`feature-desc-${index}`).value;
                
                if (title && description) {
                    features.push({ icon, title, description });
                }
            });
            
            const data = {
                action: 'update_features',
                features: features
            };
            
            await saveData(data, 'Özellikler güncellendi');
            updateStats();
        }

        // YORUMLAR YÖNETİMİ
        function loadTestimonials(testimonials) {
            const editor = document.getElementById('testimonials-editor');
            editor.innerHTML = '';
            
            testimonials.forEach((testimonial, index) => {
                const div = document.createElement('div');
                div.className = 'testimonial-item';
                div.innerHTML = `
                    <div class="form-group">
                        <label>İsim</label>
                        <input type="text" id="testimonial-name-${index}" value="${testimonial.name || ''}" placeholder="Ahmet Yılmaz">
                    </div>
                    <div class="form-group">
                        <label>Avatar URL (Opsiyonel)</label>
                        <input type="text" id="testimonial-avatar-${index}" value="${testimonial.avatar || ''}" placeholder="uploads/avatar.jpg">
                    </div>
                    <div class="form-group">
                        <label>Yıldız (1-5)</label>
                        <input type="number" id="testimonial-rating-${index}" value="${testimonial.rating || 5}" min="1" max="5">
                    </div>
                    <div class="form-group">
                        <label>Yorum</label>
                        <textarea id="testimonial-text-${index}" placeholder="Müşteri yorumu">${testimonial.text || ''}</textarea>
                    </div>
                    <div class="item-actions">
                        <button class="btn-remove" onclick="removeTestimonial(${index})">🗑️ Kaldır</button>
                    </div>
                `;
                editor.appendChild(div);
            });
            
            document.getElementById('total-testimonials').textContent = testimonials.length;
        }

        function addTestimonial() {
            const editor = document.getElementById('testimonials-editor');
            const index = editor.children.length;
            
            const div = document.createElement('div');
            div.className = 'testimonial-item';
            div.innerHTML = `
                <div class="form-group">
                    <label>İsim</label>
                    <input type="text" id="testimonial-name-${index}" placeholder="Ahmet Yılmaz">
                </div>
                <div class="form-group">
                    <label>Avatar URL (Opsiyonel)</label>
                    <input type="text" id="testimonial-avatar-${index}" placeholder="uploads/avatar.jpg">
                </div>
                <div class="form-group">
                    <label>Yıldız (1-5)</label>
                    <input type="number" id="testimonial-rating-${index}" value="5" min="1" max="5">
                </div>
                <div class="form-group">
                    <label>Yorum</label>
                    <textarea id="testimonial-text-${index}" placeholder="Müşteri yorumu"></textarea>
                </div>
                <div class="item-actions">
                    <button class="btn-remove" onclick="removeTestimonial(${index})">🗑️ Kaldır</button>
                </div>
            `;
            editor.appendChild(div);
        }

        function removeTestimonial(index) {
            const editor = document.getElementById('testimonials-editor');
            editor.children[index].remove();
            
            // Indexleri yeniden düzenle
            Array.from(editor.children).forEach((child, newIndex) => {
                child.querySelectorAll('input, textarea').forEach(input => {
                    input.id = input.id.replace(/\d+$/, newIndex);
                });
                child.querySelector('.btn-remove').onclick = () => removeTestimonial(newIndex);
            });
        }

        async function saveTestimonials() {
            const editor = document.getElementById('testimonials-editor');
            const testimonials = [];
            
            Array.from(editor.children).forEach((child, index) => {
                const name = document.getElementById(`testimonial-name-${index}`).value;
                const avatar = document.getElementById(`testimonial-avatar-${index}`).value;
                const rating = document.getElementById(`testimonial-rating-${index}`).value;
                const text = document.getElementById(`testimonial-text-${index}`).value;
                
                if (name && text) {
                    testimonials.push({ name, avatar, rating: parseInt(rating), text });
                }
            });
            
            const data = {
                action: 'update_testimonials',
                testimonials: testimonials
            };
            
            await saveData(data, 'Yorumlar güncellendi');
            updateStats();
        }

        function updateStats() {
            document.getElementById('total-features').textContent = document.getElementById('features-editor').children.length;
            document.getElementById('total-testimonials').textContent = document.getElementById('testimonials-editor').children.length;
        }
    </script>
</body>
</html>
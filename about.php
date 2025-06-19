<?php
// Koneksi ke database (opsional, bisa diperlukan jika ada data dinamis di masa depan)
// $db_host = "sql311.byethost13.com";
// $db_user = "b13_39239332";
// $db_password = "nandaaulia1004#";
// $db_name = "b13_39239332_blog_dinamis";

// $db_host = "localhost";
// $db_user = "root";
// $db_password = "";
// $db_name = "blog_dinamis";

require_once 'db_config.php';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set judul halaman sebelum memanggil header
$page_title = "Tentang QuotientNote";
include 'templates/header.php';
?>
<body>
    <!-- Floating Particles Effect -->
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 0.5s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 1.5s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 2.5s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 0.2s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 1.2s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 2.2s;"></div>
    </div>

    <!-- Floating Decorative Shapes -->
    <div class="floating-shape circle" style="top: 15%; left: 5%;"></div>
    <div class="floating-shape triangle" style="top: 25%; right: 10%;"></div>
    <div class="floating-shape square" style="bottom: 20%; left: 15%;"></div>
    <div class="floating-shape circle" style="bottom: 30%; right: 5%;"></div>

    
    <main class="parallax">
        <section class="about-hero">
            <div class="hero-content glass morphing">
                <h2 class="holographic">Tentang Blog Dinamis</h2>
                <p class="hero-subtitle">Platform berbagi pengetahuan, pengalaman, dan inspirasi</p>
            </div>
        </section>

        <section class="about-content">
            <div class="content-grid">
                <div class="content-card glass morphing">
                    <div class="card-icon">🚀</div>
                    <h3 class="text-glow">Visi Kami</h3>
                    <p>Menjadi platform terdepan untuk berbagi pengetahuan dan inspirasi, 
                       memungkinkan setiap individu untuk mengekspresikan ide dan pengalaman mereka 
                       dengan cara yang mudah dan menarik.</p>
                </div>

                <div class="content-card glass morphing">
                    <div class="card-icon">💡</div>
                    <h3 class="text-glow">Misi Kami</h3>
                    <p>Menyediakan ruang digital yang nyaman dan user-friendly untuk para penulis 
                       dari berbagai latar belakang untuk berbagi cerita, tutorial, opini, 
                       dan pengalaman hidup mereka.</p>
                </div>

                <div class="content-card glass morphing">
                    <div class="card-icon">🌟</div>
                    <h3 class="text-glow">Nilai-Nilai</h3>
                    <p>Kami percaya pada kekuatan berbagi pengetahuan, kreativitas tanpa batas, 
                       komunitas yang saling mendukung, dan teknologi yang memudahkan proses 
                       kreatif setiap individu.</p>
                </div>
            </div>
        </section>

        <section class="features-section">
            <h3 class="holographic">Fitur-Fitur Unggulan</h3>
            <div class="features-grid">
                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">✍️</div>
                    <h4 class="text-glow">Editor Mudah</h4>
                    <p>Interface yang user-friendly memungkinkan Anda menulis dan mengedit artikel dengan mudah.</p>
                </div>

                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">📂</div>
                    <h4 class="text-glow">Kategori Terorganisir</h4>
                    <p>Sistem kategori yang membantu pembaca menemukan artikel sesuai minat mereka.</p>
                </div>

                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">📱</div>
                    <h4 class="text-glow">Responsive Design</h4>
                    <p>Tampilan yang optimal di semua perangkat, dari desktop hingga smartphone.</p>
                </div>

                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">🔒</div>
                    <h4 class="text-glow">Sistem Keamanan</h4>
                    <p>Autentikasi pengguna yang aman dan perlindungan data yang terjamin.</p>
                </div>

                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">🖼️</div>
                    <h4 class="text-glow">Upload Gambar</h4>
                    <p>Dukungan upload gambar untuk memperkaya konten artikel Anda.</p>
                </div>

                <div class="feature-card glass morphing magnetic">
                    <div class="feature-icon">⚡</div>
                    <h4 class="text-glow">Performa Cepat</h4>
                    <p>Loading yang cepat dan performa optimal untuk pengalaman pengguna terbaik.</p>
                </div>
            </div>
        </section>

        <section class="contact-section">
            <div class="contact-container glass morphing">
                <h3 class="holographic">Hubungi Kami</h3>
                <p>Punya pertanyaan, saran, atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami!</p>
                
                <div class="contact-methods">
                    <div class="contact-item magnetic">
                        <div class="contact-icon">📧</div>
                        <div class="contact-info">
                            <h4>Email</h4>
                            <p>nandaaulia1004@gmail.com</p>
                        </div>
                    </div>

                    <div class="contact-item magnetic">
                        <div class="contact-icon">💬</div>
                        <div class="contact-info">
                            <h4>Media Sosial</h4>
                            <p>Instagram: @nanda.aulia10</p>
                        </div>
                    </div>

                    <div class="contact-item magnetic">
                        <div class="contact-icon">🌐</div>
                        <div class="contact-info">
                            <h4>Website</h4>
                            <p>www.blogdinamis.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="cta-container glass morphing">
                <h3 class="holographic">Bergabunglah dengan Komunitas Kami</h3>
                <p>Mulai berbagi cerita dan pengalaman Anda bersama ribuan pembaca lainnya!</p>
                <div class="cta-buttons">
                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <a href="register.php" class="btn btn-register magnetic pulse-glow">Daftar Sekarang</a>
                        <a href="login.php" class="btn btn-login magnetic">Masuk</a>
                    <?php else: ?>
                        <a href="add_article.php" class="btn btn-register magnetic pulse-glow">Tulis Artikel</a>
                        <a href="index.php" class="btn btn-login magnetic">Lihat Artikel</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> QuotientNote - <span class="holographic">Nanda Aulia</span></p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add magnetic effect to buttons
            const magneticElements = document.querySelectorAll('.magnetic');
            magneticElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.05)';
                });
                
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add intersection observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards and sections
            const animatedElements = document.querySelectorAll('.content-card, .feature-card, .profile-container, .contact-container, .cta-container');
            animatedElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(50px)';
                element.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(element);
            });

            // Animate particles
            const particles = document.querySelectorAll('.particle');
            particles.forEach((particle, index) => {
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
            });

            // Add parallax effect to floating shapes
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const shapes = document.querySelectorAll('.floating-shape');
                
                shapes.forEach((shape, index) => {
                    const speed = 0.1 + (index * 0.05);
                    shape.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // Add typing effect to hero subtitle
            const subtitle = document.querySelector('.hero-subtitle');
            if (subtitle) {
                const text = subtitle.textContent;
                subtitle.textContent = '';
                let i = 0;
                
                const typeWriter = () => {
                    if (i < text.length) {
                        subtitle.textContent += text.charAt(i);
                        i++;
                        setTimeout(typeWriter, 50);
                    }
                };
                
                setTimeout(typeWriter, 1000);
            }
        });
    </script>
</body>
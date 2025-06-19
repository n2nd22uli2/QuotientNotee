<?php
session_start(); // Pastikan session dimulai untuk header

// Koneksi ke database
require_once 'db_config.php';

// $db_host = "sql311.byethost13.com";
// $db_user = "b13_39239332";
// $db_password = "nandaaulia1004#";
// $db_name = "b13_39239332_blog_dinamis";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$error_message = '';

if (empty($slug)) {
    $error_message = "Artikel tidak ditemukan.";
} else {
    // Query untuk mengambil artikel, kategori, dan nama penulis
    $sql = "SELECT a.*, GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as categories, u.username as author_name
            FROM articles a
            LEFT JOIN article_category ac ON a.article_id = ac.article_id
            LEFT JOIN categories c ON ac.category_id = c.category_id
            LEFT JOIN users u ON a.author_id = u.user_id
            WHERE a.slug = ? AND a.status = 'published'
            GROUP BY a.article_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        $error_message = "Artikel tidak ditemukan atau belum dipublikasikan.";
    }
}

// Set judul halaman sebelum memanggil header
$page_title = isset($article) ? htmlspecialchars($article["title"]) : "Artikel Tidak Ditemukan";

// === AWAL PENAMBAHAN KODE: CSS dan Header ===
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - QuotientNote</title>
    <link rel="stylesheet" href="index.css"> <link rel="stylesheet" href="article.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        /* CSS untuk form pencarian - Sama persis seperti di index.php */
        .search-container {
            display: flex;
            gap: 10px;
            /* Menjaga elemen agar berada di tengah secara vertikal, membantu kerapian */
            align-items: center; 
        }
        .search-container input[type="text"] {
            margin-top: 20px;
            flex-grow: 1; 
            padding: 0 10px; /* Padding horizontal saja */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box; 
            /* KUNCI UTAMA: Memberikan tinggi eksplisit yang sama */
            height: 42px; 
        }
        .search-container .search-button {
            flex-shrink: 0;
            width: auto; 
            padding: 0 20px; /* Padding horizontal saja */
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            border: 1px solid #007bff; 
            box-sizing: border-box; 
            /* KUNCI UTAMA: Memberikan tinggi eksplisit yang sama */
            height: 40px; 
            /* Memastikan teks di dalam tombol juga center */
            line-height: 38px;
        }
        .search-container .search-button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
    <div class="container">
        <div class="header-left">
            <h1><a href="index.php">QuotientNote</a></h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="add_article.php">Tambah Artikel</a></li>
                    <li><a href="categories.php">Kategori</a></li>
                    <li><a href="about.php">Tentang</a></li>
                </ul>
            </nav>
        </div>

        <div class="header-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="welcome-message">Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <span class="admin-badge">Admin</span>
                <?php endif; ?>

                <a href="add_article.php" class="btn btn-primary">Tambah Artikel</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>

            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php
// === AKHIR PENAMBAHAN KODE ===
?>

<?php if (isset($article)): ?>
<main class="container page-layout">
    <div class="main-content">
        <article class="article-full-content">
            <header class="article-header <?php echo empty($article["featured_image"]) ? 'article-header-no-image' : ''; ?>">
                <?php if(!empty($article["featured_image"])): ?>
                    <img src="<?php echo htmlspecialchars($article["featured_image"]); ?>" alt="<?php echo htmlspecialchars($article["title"]); ?>" class="article-header-image">
                <?php endif; ?>
                <div class="article-header-content">
                    <div class="category-badges">
                        <?php 
                        if(!empty($article["categories"])) {
                            foreach(explode(',', $article["categories"]) as $category) {
                                echo '<span class="category-badge">' . htmlspecialchars(trim($category)) . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <h1 class="article-title"><?php echo htmlspecialchars($article["title"]); ?></h1>
                </div>
            </header>
            
            <div class="article-details">
                <div class="article-meta">
                    <span class="meta-item"><i class="far fa-calendar-alt"></i> <?php echo (new DateTime($article["published_at"]))->format('d F Y'); ?></span>
                    <span class="meta-item"><i class="far fa-user"></i> <?php echo !empty($article["author_name"]) ? htmlspecialchars($article["author_name"]) : "Penulis"; ?></span>
                </div>
                
                <div class="article-body">
                    <?php echo nl2br($article["content"]); // nl2br untuk mengubah baris baru menjadi <br> ?>
                </div>
                
                <div class="article-footer">
                    <div class="action-buttons">
                        <button><i class="far fa-heart"></i> Suka</button>
                    </div>
                    <div class="share-links">
                        <span>Bagikan:</span>
                        <a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                        <a href="https://id.linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </article>
    </div>
    
    <aside class="sidebar">
        <div class="widget">
            <h3>Pencarian</h3>
            <form action="index.php" method="GET" class="search-form">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Cari artikel...">
                    <button type="submit" class="search-button">Cari</button>
                </div>
            </form>
        </div>
        <div class="widget">
            <h3>Kategori</h3>
            <?php
            $cat_sql = "SELECT c.name, c.slug, COUNT(ac.article_id) as article_count 
                        FROM categories c
                        LEFT JOIN article_category ac ON c.category_id = ac.category_id
                        LEFT JOIN articles a ON ac.article_id = a.article_id AND a.status = 'published'
                        GROUP BY c.category_id ORDER BY c.name";
            $cat_result = $conn->query($cat_sql);
            if ($cat_result && $cat_result->num_rows > 0) {
                echo "<ul>";
                while($cat_row = $cat_result->fetch_assoc()) {
                    // Hanya tampilkan kategori yang memiliki artikel
                    if ($cat_row["article_count"] > 0) {
                       echo "<li><a href='category.php?slug=" . htmlspecialchars($cat_row["slug"]) . "'>" . htmlspecialchars($cat_row["name"]) . " <span>(" . $cat_row["article_count"] . ")</span></a></li>";
                    }
                }
                echo "</ul>";
            }
            ?>
        </div>
        
        <div class="widget">
            <h3>Artikel Terbaru</h3>
            <?php
            $recent_sql = "SELECT title, slug FROM articles WHERE status = 'published' AND slug != ? ORDER BY published_at DESC LIMIT 4";
            $recent_stmt = $conn->prepare($recent_sql);
            $recent_stmt->bind_param("s", $slug);
            $recent_stmt->execute();
            $recent_result = $recent_stmt->get_result();
            if ($recent_result && $recent_result->num_rows > 0) {
                echo "<ul>";
                while($recent_row = $recent_result->fetch_assoc()) {
                    echo "<li><a href='article.php?slug=" . htmlspecialchars($recent_row["slug"]) . "'>" . htmlspecialchars($recent_row["title"]) . "</a></li>";
                }
                echo "</ul>";
            }
            ?>
        </div>
    </aside>
</main>

<button class="back-to-top-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</button>

<?php else: ?>
<main class="container">
    <div class="message error-message" style="text-align: center; padding: 50px; background-color: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h1>Oops! 😟</h1>
        <p style="font-size: 1.2em;"><?php echo htmlspecialchars($error_message); ?></p>
        <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Kembali ke Beranda</a>
    </div>
</main>
<?php endif; ?>

<?php
// Mengganti include 'templates/footer.php'; dengan kode footer langsung untuk kelengkapan
?>
<footer>
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> QuotientNote. Nanda Aulia. </p>
    </div>
</footer>
</body>
</html>
<?php 
if (isset($stmt)) {
    $stmt->close();
}
$conn->close(); 
?>
<!-- index.php  -->
<?php
session_start();

require_once 'db_config.php';

// Koneksi ke database
// $db_host = "sql311.byethost13.com";
// $db_user = "b13_39239332";
// $db_password = "nandaaulia1004#";
// $db_name = "b13_39239332_blog_dinamis";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inisialisasi variabel pencarian
$search_query = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
}

// Query dasar untuk mengambil artikel
$sql = "SELECT a.article_id, a.title, a.excerpt, a.slug, a.featured_image, a.published_at, a.author_id,
               GROUP_CONCAT(DISTINCT c.name) AS categories
        FROM articles a
        LEFT JOIN article_category ac ON a.article_id = ac.article_id
        LEFT JOIN categories c ON ac.category_id = c.category_id";

// Tambahkan kondisi pencarian jika ada
if ($search_query) {
    // Cari berdasarkan judul atau kutipan
    $sql .= " WHERE a.status = 'published' AND (a.title LIKE ? OR a.excerpt LIKE ?)";
} else {
    $sql .= " WHERE a.status = 'published'";
}

$sql .= " GROUP BY a.article_id ORDER BY a.published_at DESC";

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare($sql);

if ($search_query) {
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuotientNote - Beranda</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* CSS untuk form pencarian - SOLUSI FINAL & PASTI */
        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
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
        .carian {
            /* margin-top: 150px; */
            font-size: 1.5rem; /* Ukuran dibuat seperti sub-judul */
            font-weight: 700; /* Sedikit lebih tipis dari 800 agar tidak terlalu ramai */
            color: #6a11cb; /* Warna ungu yang elegan dan cocok dengan tema */
            margin-top: 2rem; /* Jarak dari "Artikel Terbaru" */
            
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
                    <li><a href="index.php" class="active">Beranda</a></li>
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

                <div class="user-menu">
                    <button class="user-menu-btn">▼</button>
                    
                    <div class="user-menu-content">
                        <div class="user-menu-header">
                            <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                            <small><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'User'; ?></small>
                        </div>
                        <a href="profile.php" class="user-menu-link profile-link">Profile</a>
                        <a href="my_articles.php" class="user-menu-link articles-link">Artikel Saya</a>
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <hr class="user-menu-divider">
                            <a href="manage_users.php" class="user-menu-link manage-users-link">Manage Users</a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

    <main class="container">
        <section class="articles">
            <h2>Artikel Terbaru</h2>
            
            <p class="carian">Pencarian</p>
            <form action="index.php" method="GET" class="search-form">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Cari artikel..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="search-button">Cari</button>
                </div>
            </form>
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $categories = !empty($row["categories"]) ? explode(',', $row["categories"]) : [];
                    $date = new DateTime($row["published_at"]);
                    $formatted_date = $date->format('d F Y');
            ?>
                    <article class="article-card">
                        <?php if($row["featured_image"]): ?>
                        <div class="article-image">
                            <img src="<?php echo htmlspecialchars($row["featured_image"]); ?>" alt="<?php echo htmlspecialchars($row["title"]); ?>">
                        </div>
                        <?php endif; ?>
                        
                        <div class="article-content">
                            <h3><a href="article.php?slug=<?php echo htmlspecialchars($row["slug"]); ?>"><?php echo htmlspecialchars($row["title"]); ?></a></h3>
                            <p class="excerpt"><?php echo htmlspecialchars($row["excerpt"]); ?></p>
                            <small>Dipublikasikan pada <?php echo $formatted_date; ?></small>
                            <br>
                            <a href="article.php?slug=<?php echo htmlspecialchars($row["slug"]); ?>" class="read-more">Baca selengkapnya</a>

                            <?php
                            // Tombol aksi untuk admin atau pemilik artikel
                            if (isset($_SESSION['user_id']) && ( (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') || $_SESSION['user_id'] == $row['author_id']) ) {
                            ?>
                                <div class="article-actions">
                                    <a href="edit_article.php?id=<?php echo $row['article_id']; ?>">Edit</a>
                                    <a href="delete_article.php?id=<?php echo $row['article_id']; ?>" onclick="return confirm('Anda yakin ingin menghapus artikel ini?');" style="color: red;">Delete</a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </article>
            <?php
                }
            } else {
                if ($search_query) {
                    echo "<p>Tidak ada artikel yang cocok dengan pencarian Anda untuk: '<strong>" . htmlspecialchars($search_query) . "</strong>'.</p>";
                } else {
                    echo "<p>Belum ada artikel yang dipublikasikan.</p>";
                }
            }
            ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> QuotientNote. Nanda Aulia. </p>
        </div>
    </footer>
</body>
</html>
<?php 
$stmt->close();
$conn->close(); 
?>
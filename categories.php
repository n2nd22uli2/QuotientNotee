<?php
// Set judul halaman sebelum memanggil header
$page_title = "Daftar Kategori";

// Karena kita butuh session untuk header, pastikan session_start() ada
session_start(); 

require_once 'db_config.php';

// $db_host = "sql311.byethost13.com";
// $db_user = "b13_39239332";
// $db_password = "nandaaulia1004#";
// $db_name = "b13_39239332_blog_dinamis";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Logika untuk menangani input pencarian
$search_query = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
}

// 2. Query dasar untuk daftar kategori
$sql = "SELECT c.category_id, c.name, c.slug, c.description, COUNT(a.article_id) as article_count 
        FROM categories c
        LEFT JOIN article_category ac ON c.category_id = ac.category_id
        LEFT JOIN articles a ON ac.article_id = a.article_id AND a.status = 'published'";

// Tambahkan kondisi WHERE untuk pencarian
if ($search_query) {
    // Cari berdasarkan nama atau deskripsi kategori
    $sql .= " WHERE c.name LIKE ? OR c.description LIKE ?";
}

$sql .= " GROUP BY c.category_id ORDER BY c.name";

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare($sql);

if ($search_query) {
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();


// Panggil header setelah semua logika selesai
include 'templates/header.php';
?>

<style>
    .search-container {
        display: flex;
        gap: 10px;
        margin-bottom: 2rem; /* Jarak ke grid kategori */
        align-items: center; 
    }
    .search-container input[type="text"] {
        margin-top: 20px;
        flex-grow: 1; 
        padding: 0 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        box-sizing: border-box; 
        height: 40px; 
    }
    .search-container .search-button {
        flex-shrink: 0;
        width: auto; 
        padding: 0 20px;
        color: white;
        background-color: #007bff;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        border: 1px solid #007bff; 
        box-sizing: border-box; 
        height: 40px; 
        line-height: 38px;
    }
    .search-container .search-button:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

<main class="container page-layout">
    <div class="main-content">
        <section class="categories-list">
            <h1 class="page-title">Daftar Kategori</h1>
            
            <form action="categories.php" method="GET" class="search-form">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Cari kategori..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="search-button">Cari</button>
                </div>
            </form>

            <div class="categories-grid">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                        <div class="category-card">
                            <div class="card-content">
                                <h2><a href="category.php?slug=<?php echo htmlspecialchars($row["slug"]); ?>"><?php echo htmlspecialchars($row["name"]); ?></a></h2>
                                <?php if($row["description"]): ?>
                                    <p class="description"><?php echo htmlspecialchars($row["description"]); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <span class="article-count"><?php echo $row["article_count"]; ?> artikel</span>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    // 4. Pesan jika hasil pencarian tidak ditemukan
                    if ($search_query) {
                        echo "<p>Tidak ada kategori yang cocok dengan pencarian Anda untuk: '<strong>" . htmlspecialchars($search_query) . "</strong>'.</p>";
                    } else {
                        echo "<p>Belum ada kategori yang ditambahkan.</p>";
                    }
                }
                ?>
            </div>
        </section>
    </div>
    
    <aside class="sidebar">
        <div class="widget">
            <h3>Artikel Terbaru</h3>
            <?php
            // Query untuk artikel terbaru
            $recent_sql = "SELECT title, slug FROM articles WHERE status = 'published' ORDER BY published_at DESC LIMIT 5";
            $recent_result = $conn->query($recent_sql);
            
            if ($recent_result && $recent_result->num_rows > 0) {
                echo "<ul>";
                while($recent_row = $recent_result->fetch_assoc()) {
                    echo "<li><a href='article.php?slug=" . htmlspecialchars($recent_row["slug"]) . "'>" . htmlspecialchars($recent_row["title"]) . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Tidak ada artikel terbaru.</p>";
            }
            ?>
        </div>
    </aside>
</main>

<?php
$stmt->close();
$conn->close();
include 'templates/footer.php';
?>
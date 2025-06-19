├── about.php                # Halaman tentang
├── add_article.php         # Menambahkan artikel baru
├── article.php             # Menampilkan artikel tunggal
├── authors_table_update.php# Skrip untuk memperbarui tabel penulis
├── categories.php          # Manajemen kategori
├── category.php            # Menampilkan artikel berdasarkan kategori
├── db_config.php           # Konfigurasi koneksi database
├── delete_article.php      # Menghapus artikel
├── edit_article.php        # Mengedit artikel
├── index.css               # Gaya utama
├── index.php               # Halaman utama (daftar artikel)
├── login.php               # Form login pengguna
├── logout.php              # Logout pengguna
├── manage_users.php        # Manajemen pengguna (admin)
├── my_articles.css         # Gaya untuk halaman artikel milik pengguna
├── my_articles.php         # Artikel milik pengguna
├── profile.php             # Profil pengguna
├── register.php            # Form pendaftaran pengguna

**PENJELASAN: **

**1. Autentikasi Pengguna**
- register.php: Halaman registrasi untuk pengguna baru. Form ini menyimpan data pengguna ke database.
- login.php & logout.php: Login memverifikasi data pengguna dengan database, lalu menyimpan sesi.
- Logout menghapus sesi untuk keluar dari sistem.

**2. Manajemen Pengguna (Admin)**
- manage_users.php: Hanya bisa diakses oleh admin. Menampilkan daftar pengguna dan kemungkinan fitur untuk menonaktifkan atau menghapus akun.
- profile.php: Menampilkan profil pengguna yang sedang login.

**3. Manajemen Artikel**
- add_article.php: Halaman untuk menambahkan artikel baru.
- Artikel biasanya memuat: judul, isi, kategori, dan penulis.
- edit_article.php: Digunakan untuk mengedit artikel yang sudah ada.
- delete_article.php: Menghapus artikel berdasarkan ID.
- my_articles.php: Menampilkan daftar artikel milik pengguna yang sedang login.
- article.php: Menampilkan detail satu artikel secara lengkap.
- index.php: Halaman utama yang menampilkan daftar semua artikel terbaru. Artikel ditampilkan dengan ringkasan dan tautan untuk membaca selengkapnya.

**4. Kategori**
- categories.php: Digunakan admin untuk mengelola (menambah, menghapus, edit) kategori.
- category.php: Menampilkan daftar artikel berdasarkan kategori yang dipilih.

**5. Utility & Konfigurasi**
- db_config.php: File konfigurasi koneksi database (host, username, password, nama DB).
- authors_table_update.php: Kemungkinan skrip sekali jalan untuk memperbarui struktur tabel penulis (migrasi).

**6. Halaman Informasi**
- about.php: Menampilkan informasi tentang sistem atau pengembang.

**7. Tampilan (CSS)**
- index.css dan my_articles.css: Berisi aturan gaya sederhana untuk tampilan halaman web.

**Alur Kerja Pengguna:**
1. Registrasi → Login
2. Buat Artikel → Artikel tampil di beranda
3. Artikel bisa dibaca, diedit, atau dihapus (jika milik sendiri)
4. Admin bisa mengelola kategori dan pengguna
5. Semua artikel diklasifikasikan berdasarkan kategori


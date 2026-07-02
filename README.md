# PocketLedger: Sistem Manajemen Kas Pribadi Terintegrasi

PocketLedger adalah aplikasi berbasis web berskala penuh (*Full-Stack Web Application*) yang dirancang untuk mempermudah pencatatan, pemantauan, dan analisis arus kas pribadi sehari-hari. Dibangun menggunakan arsitektur modular PHP murni (*Native PHP*) pada sisi *backend* dan komunikasi asinkron berbasis AJAX/Fetch API pada sisi *frontend*, sistem ini menawarkan performa tinggi, keamanan multi-pengguna (*multi-user isolation*), serta antarmuka visual *Neo-Brutalist* bertema kontras tinggi yang interaktif dan ergonomis.

Proyek ini dikembangkan sebagai implementasi nyata dari sistem CRUD (*Create, Read, Update, Delete*) yang tuntas, manajemen relasi basis data MySQL, perlindungan keamanan siber dasar, serta visualisasi data analitik secara langsung (*real-time*).

---

## 🏗️ Arsitektur & Struktur Direktori Proyek

Proyek ini menerapkan struktur direktori modular untuk memisahkan antara logika konfigurasi, antarmuka pengguna (*view/includes*), pemrosesan fungsional (*actions*), dan aset pendukung:

```text
project_UAS/
├── actions/                  # Endpoint pemrosesan logika backend (AJAX & Form POST)
│   ├── auth_change_password.php # Pembaruan kata sandi pengguna
│   ├── auth_delete_account.php  # Penghapusan akun permanen & pembersihan data
│   ├── auth_login.php           # Verifikasi kredensial & inisialisasi sesi
│   ├── auth_logout.php          # Terminasi sesi pengguna
│   ├── auth_register.php        # Pendaftaran akun baru & enkripsi BCRYPT
│   ├── budget_update.php        # Pembaruan target batas anggaran bulanan
│   ├── transaction_create.php   # Pencatatan transaksi baru (Pemasukan/Pengeluaran)
│   ├── transaction_delete.php   # Penghapusan catatan transaksi berdasarkan ID
│   ├── transaction_update.php   # Penyuntingan rincian transaksi historis
│   └── transactions_get.php     # Penyediaan data transaksi dalam format JSON
├── config/
│   └── db.php                   # Konfigurasi koneksi database MySQL menggunakan PDO
├── docs/
│   ├── database.sql             # Skema DDL pembuatan database dan tabel relasional
│   └── prompt.md                # Dokumentasi spesifikasi & rancangan proyek
├── includes/
│   ├── header.php               # Komponen tata letak atas, variabel CSS, & navigasi
│   └── footer.php               # Komponen tata letak bawah & skrip tema gelap
├── index.php                    # Dasbor utama aplikasi (Single-Page Interface)
├── login.php                    # Halaman autentikasi masuk
├── register.php                 # Halaman pendaftaran akun baru
├── profile.php                  # Halaman manajemen akun & keamanan pengguna
└── README.md                    # Dokumentasi utama proyek
```

---

## 🛠️ Spesifikasi Teknologi

*   **Bahasa Pemrograman Backend**: PHP 8+ (Menggunakan antarmuka PDO / *PHP Data Objects* dengan *Prepared Statements* untuk perlindungan mutlak terhadap ancaman *SQL Injection*).
*   **Sistem Manajemen Basis Data**: MySQL (Desain tabel relasional dengan *Constraint Foreign Key*).
*   **Frontend & Interaktivitas**: Vanilla JavaScript (ES6+ Asynchronous Fetch API) dan HTML5 Semantik.
*   **Styling & Desain Sistem**: Tailwind CSS v3 (Disusun secara fungsional untuk menghasilkan antarmuka *Retro Neo-Brutalist* dengan bayangan solid dan kontras tinggi).
*   **Pustaka Pihak Ketiga (*Library*)**:
    *   `Chart.js`: Pustaka visualisasi grafik interaktif berbasis kanvas HTML5.
    *   `html2pdf.js`: Pustaka pemrosesan konversi elemen DOM HTML menjadi dokumen PDF secara langsung di peramban klien.

---

## 🗄️ Skema Basis Data (Database Schema)

Database proyek ini bernama **`pocketledger`** dan terdiri dari dua tabel utama yang saling berelasi:

1.  **Tabel `users`**: Menyimpan identitas akun pengguna.
    *   `id` (INT, Primary Key, Auto Increment)
    *   `username` (VARCHAR(50), Unique Index)
    *   `password` (VARCHAR(255), Enkripsi BCRYPT)
    *   `monthly_budget_limit` (BIGINT, Default 0)
    *   `created_at` (TIMESTAMP)
2.  **Tabel `transactions`**: Menyimpan riwayat arus kas finansial.
    *   `id` (INT, Primary Key, Auto Increment)
    *   `user_id` (INT, Foreign Key mereferensi ke `users(id)` dengan aturan `ON DELETE CASCADE`)
    *   `type` (ENUM: 'Pemasukan', 'Pengeluaran')
    *   `category` (VARCHAR(100))
    *   `amount` (BIGINT)
    *   `description` (TEXT)
    *   `transaction_date` (DATE)
    *   `created_at` (TIMESTAMP)

---

## 🌟 Rincian Fitur & Fungsionalitas Lengkap

### 1. Sistem Autentikasi & Keamanan Akun (Multi-User)
Sistem dirancang dengan arsitektur isolasi sesi (*session-based isolation*) yang menjamin privasi dan keamanan data finansial setiap pengguna.
*   **Enkripsi Kata Sandi**: Kata sandi pengguna tidak pernah disimpan dalam bentuk teks biasa (*plain text*), melainkan diacak menggunakan algoritma *hashing* standar industri (`PASSWORD_BCRYPT`).
*   **Isolasi Data Sesi**: Setiap pencatatan transaksi diikat secara spesifik pada `user_id` yang sedang aktif. Pengguna A tidak dapat melihat, memodifikasi, atau menghapus catatan finansial milik pengguna B.
*   **Desain Form Autentikasi Intuitif**: Halaman *Login* dan *Register* dilengkapi dengan keterangan *placeholder* berbahasa Indonesia yang jelas ("Masukkan Username", "Masukkan Password", "Buat Username", "Buat Password") serta tombol ikon mata (*toggle password visibility*) untuk mengintip atau menyembunyikan sandi saat diketik.
*   **Manajemen Profil Mandiri**: Pengguna difasilitasi dengan halaman **Profil Saya** untuk memperbarui kata sandi lama secara berkala demi menjaga keamanan akun.
*   **Penghapusan Akun Permanen (*Danger Zone*)**: Dilengkapi dengan fitur pemusnahan akun berlapis konfirmasi peringatan ganda (*JavaScript Confirm Dialog*). Saat disetujui, *backend* akan membersihkan seluruh transaksi historis pengguna terlebih dahulu sebelum menghapus identitas akun dari sistem server.

### 2. Manajemen Arus Kas (CRUD Lengkap & Dinamis)
Modul pencatatan kas dirancang dengan interaksi minim hambatan (*frictionless UX*) tanpa perlu memuat ulang keseluruhan halaman web.
*   **Pencatatan & Penyuntingan (*Create & Update*)**: Pengguna dapat mencatat nominal, tipe kas (Pemasukan/Pengeluaran), kategori, dan keterangan transaksi. Tersedia tombol biru **[EDIT]** pada setiap baris riwayat untuk memuat ulang data ke formulir input dan menyimpan perubahannya secara instan.
*   **Kategori Dinamis Berkelanjutan**: Sistem tidak membatasi pilihan kategori secara kaku. Ketika pengguna mengetikkan nama kategori baru (misal: "Investasi Saham" atau "Perawatan Kendaraan"), kategori tersebut akan direkam secara otomatis dan muncul pada menu tarik-turun (*dropdown*) di sesi input berikutnya.
*   **Mekanisme Anti-Spam (*Loading State*)**: Setiap operasi pengiriman formulir atau penghapusan data disertai dengan indikator pemrosesan visual (seperti perubahan teks tombol menjadi `MENYIMPAN...` atau `[...]`). Tombol akan dinonaktifkan sementara untuk mencegah entri ganda akibat klik berulang.

### 3. Analitik Visual & Filter Pemilahan Cerdas
Seluruh data mentah diproses menjadi laporan analitik visual yang interaktif dan mudah dipahami.
*   **Visualisasi Multi-Grafik (*Chart.js*)**: Pengguna dapat memilih 4 mode representasi grafik pengeluaran: **Donat (*Doughnut*)**, **Lingkaran (*Pie*)**, **Batang (*Bar*)**, dan **Garis (*Line*)**. Grafik akan secara otomatis menghitung dan mengelompokkan proporsi pengeluaran berdasarkan kategori.
*   **Pemfilteran Rentang Waktu Ganda**: 
    *   *Filter Bulan*: Memilah transaksi berdasarkan bulan tertentu atau menampilkan keseluruhan riwayat.
    *   *Filter Rentang Tanggal Kalender (Dari Tanggal s/d Tanggal)*: Memungkinkan pengguna menyaring laporan secara sangat spesifik (misal: hanya melihat pengeluaran liburan dari 10 Juni hingga 15 Juni).
*   **Pencarian Pintar (*Live Search*)**: Kotak pencarian langsung yang menyaring tabel transaksi secara *real-time* berdasarkan kata kunci keterangan atau kategori saat pengguna mengetik.

### 4. Modul Ekspor Laporan Profesional
Mendukung generasi dokumen eksternal untuk keperluan pengolahan akuntansi lanjutan maupun pencetakan arsip fisik.
*   **Ekspor Excel (CSV)**: Tombol **⬇️ CSV (EXCEL)** mengonversi data yang sedang tampil pada tabel menjadi berkas *Comma-Separated Values* (*.csv). Berkas ini siap dibuka dan diolah lebih lanjut menggunakan rumus di Microsoft Excel atau Google Sheets.
*   **Cetak Laporan PDF Ber-Kop**: Tombol **📄 CETAK PDF** menyusun dokumen berformat A4 yang dilengkapi judul laporan, tanggal cetak, serta parameter filter aktif (misal: `Periode: Juni 2026`, `Jenis: Semua Transaksi`).
*   **Rekapitulasi Kalkulasi Otomatis di PDF**: Bagian bawah tabel laporan PDF secara otomatis menyertakan 2 baris ringkasan kalkulasi:
    1.  **TOTAL (PERIODE AKTIF)**: Menjumlahkan seluruh angka pemasukan dan pengeluaran pada filter yang dipilih.
    2.  **HASIL BERSIH (Pemasukan - Pengeluaran)**: Menghitung selisih neto arus kas. Angka akan berwarna **Hijau (+)** jika surplus dan berwarna **Merah (-)** jika defisit.

### 5. Utilitas & Ergonomi Dasbor
*   **Batas Anggaran (*Budget Limiter*)**: Penggeser interaktif (*range slider*) untuk menetapkan target maksimal pengeluaran bulanan. Kartu statistik di bagian atas dasbor akan mengalkulasi dan menampilkan persentase kuota anggaran yang telah terpakai.
*   **Kalkulator Retro Terintegrasi**: Komponen kalkulator fungsional di samping tabel arus kas untuk membantu pengguna menghitung total penjumlahan struk atau nota belanja sebelum nominalnya dimasukkan ke dalam sistem.
*   **Adaptasi Tema Gelap (*Dark Mode*)**: Tombol sakelar **🌙 DARK_MODE** mengubah keseluruhan skema warna aplikasi. Sistem secara cerdas membalik warna latar belakang, batas garis (*border*), teks kontras, hingga memuat ulang warna kanvas grafik *Chart.js* agar mata tetap nyaman saat menggunakan aplikasi di ruangan minim cahaya.

---

## 💻 Panduan Instalasi & Pengoperasian Lokal

Ikuti langkah-langkah berikut untuk menjalankan aplikasi PocketLedger di komputer lokal Anda:

1.  **Persiapan Server Lokal**: Pastikan Anda telah menginstal aplikasi web server lokal seperti **XAMPP**, **MAMP**, atau **Laragon**. Buka panel kontrol aplikasi tersebut dan aktifkan modul **Apache** serta **MySQL**.
2.  **Penempatan Berkas Proyek**: Salin atau *clone* folder proyek ini (`project_UAS`) ke dalam direktori *root server* Anda:
    *   Jika menggunakan XAMPP di Windows: letakkan di dalam folder `C:\xampp\htdocs\project_UAS`.
3.  **Pembuatan Basis Data**:
    *   Buka peramban web (*browser*) dan akses manajemen database di: `http://localhost/phpmyadmin`.
    *   Buat database baru dengan nama tepat: **`pocketledger`**.
4.  **Impor Skema SQL**:
    *   Klik database `pocketledger` yang baru saja dibuat.
    *   Pilih menu **Import** (Impor), lalu unggah berkas skema database yang terletak di path proyek: `project_UAS/docs/database.sql`. Klik **Go / Kirim** hingga seluruh tabel (`users` dan `transactions`) berhasil dibentuk.
5.  **Pemeriksaan Konfigurasi Koneksi**:
    *   Buka berkas `config/db.php` di teks editor Anda.
    *   Pastikan parameter koneksi database sesuai dengan pengaturan MySQL Anda (secara bawaan pada XAMPP, *username* adalah `'root'` dan *password* dikosongkan `''`).
6.  **Akses Aplikasi**:
    *   Buka *browser* Anda dan ketikkan alamat URL:
        ```text
        http://localhost/project_UAS
        ```
    *   Anda akan diarahkan ke halaman **Login**. Silakan klik tautan **Register** untuk mendaftarkan akun baru terlebih dahulu, kemudian masuk dan nikmati pengelolaan kas finansial Anda!

---

## 🚀 Panduan Deployment ke Vercel (Cloud Hosting)

Aplikasi PocketLedger didesain agar siap dipublikasikan ke platform *cloud hosting* **Vercel** menggunakan arsitektur *Serverless PHP Runtime*. Karena Vercel beroperasi secara *serverless*, berikut adalah langkah-langkah penyiapan yang harus dipenuhi:

### 1. Penyediaan Basis Data Cloud (Cloud MySQL)
Karena lingkungan serverless Vercel tidak memiliki server database lokal (`localhost`), Anda wajib menggunakan penyedia layanan database MySQL berbasis *cloud* gratis/berbayar seperti **Aiven**, **TiDB Cloud**, **Railway**, atau **PlanetScale**.
*   Buat database baru pada penyedia cloud pilihan Anda.
*   Jalankan (*import*) berkas skema database `docs/database.sql` ke dalam cloud database tersebut.
*   Catat informasi kredensial koneksi cloud database Anda: *Host URL*, *Port*, *Database Name*, *Username*, dan *Password*.

### 2. Konfigurasi Repositori Git
Proyek ini telah dilengkapi dengan 2 konfigurasi otomatis untuk mendukung Vercel:
*   **`vercel.json`**: Menginstruksikan Vercel untuk memproses berkas `.php` menggunakan *runtime* resmi/komunitas `vercel-php`.
*   **`config/db.php`**: Telah dikonfigurasikan agar secara otomatis membaca *Environment Variables* di cloud serverless atau *fallback* ke `127.0.0.1` saat dijalankan di XAMPP lokal.

Unggah (*push*) seluruh kode proyek ini ke repositori **GitHub** Anda.

### 3. Pengaturan Impor Proyek di Vercel Dasbor
1.  Masuk ke dasbor [Vercel](https://vercel.com/) dan klik **Add New Project**.
2.  Impor repositori GitHub proyek **PocketLedger** Anda.
3.  Sebelum menekan tombol *Deploy*, buka menu **Environment Variables** pada pengaturan proyek Vercel tersebut dan tambahkan variabel berikut sesuai dengan kredensial Cloud MySQL Anda:
    *   `DB_HOST`: Alamat host cloud database (misal: `mysql-xxxx.aivencloud.com`)
    *   `DB_PORT`: Port database (misal: `19810` atau `3306`)
    *   `DB_NAME`: Nama database (misal: `defaultdb` atau `pocketledger`)
    *   `DB_USER`: Username cloud database
    *   `DB_PASS`: Kata sandi cloud database
4.  Klik **Deploy**. Vercel akan mengompilasi aplikasi PHP Anda menjadi *Serverless Functions* yang super cepat dan aplikasi Anda siap diakses oleh publik dari seluruh dunia!

---
*PocketLedger Web Application © 2026 — Developed for Final Project Submission.*

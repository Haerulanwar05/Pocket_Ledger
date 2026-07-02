# 📒 PocketLedger: Sistem Manajemen Kas Pribadi Terintegrasi (Cloud-Native Edition)

[![Live Demo on Vercel](https://img.shields.io/badge/LIVE_DEMO-VERCEL_CLOUD-000000?style=for-the-badge&logo=vercel&logoColor=white)](https://pocket-ledger-nfln.vercel.app)
[![Tech Stack PHP](https://img.shields.io/badge/BACKEND-PHP_8%2B_(PDO)-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tech Stack MySQL](https://img.shields.io/badge/DATABASE-CLOUD_MYSQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![UI Neo-Brutalist](https://img.shields.io/badge/UI_UX-NEO--BRUTALIST-F59E0B?style=for-the-badge)](https://tailwindcss.com)

**PocketLedger** adalah aplikasi web modern berskala penuh (*Full-Stack Web Application*) yang dirancang khusus untuk mempermudah pencatatan, pemantauan, dan analisis arus kas pribadi sehari-hari secara transparan dan aman. 

Ditempatkan di infrastruktur cloud serverless **Vercel** dengan konektivitas basis data **Cloud MySQL**, aplikasi ini menghadirkan kecepatan akses tinggi yang dapat dibuka secara instan dari perangkat komputer maupun ponsel pintar di mana pun Anda berada.

Secara visual, PocketLedger mengadopsi bahasa desain kreatif **Retro Neo-Brutalist** yang memadukan latar belakang kertas kas digital (*ledger grid pattern*), lencana informatif bergaya kabinet arsip retro, bayangan kontras tegas, serta palet warna kuning emas khas catatan keuangan kelas atas.

---

## 🌐 Akses Langsung Aplikasi (Live Cloud Access)

Aplikasi PocketLedger telah dipublikasikan secara online dan siap digunakan 24/7 tanpa perlu instalasi aplikasi di komputer Anda. Silakan kunjungi tautan resmi berikut:

### 👉 **[https://pocket-ledger-nfln.vercel.app](https://pocket-ledger-nfln.vercel.app)**

> **Tips Akses Cepat:** Jika Anda baru pertama kali berkunjung, silakan klik tombol **"Belum punya akun? Register"** pada halaman utama untuk membuat akun baru dalam hitungan detik.

---

## 🛠️ Spesifikasi Teknologi & Keunggulan Sistem

*   **Arsitektur Serverless Cloud**: Digerakkan oleh *Vercel PHP Serverless Runtime* dengan pola *Front Controller (`api/index.php`)* yang menjamin waktu respons ekstrim (*low latency*).
*   **Perlindungan Basis Data Absolut**: Menggunakan antarmuka **PDO (*PHP Data Objects*)** dengan **Prepared Statements**, sehingga sistem 100% kebal terhadap serangan penyusupan data (*SQL Injection*).
*   **Isolasi Multi-Pengguna (*Multi-User Isolation*)**: Setiap data transaksi diverifikasi secara ketat berdasarkan sesi ID pengguna (`user_id`). Privasi kas finansial antar pengguna terjamin sepenuhnya.
*   **Desain Interaktif Asinkron**: Komunikasi antar antarmuka dan server menggunakan **Vanilla JavaScript Fetch API (AJAX)** sehingga pencatatan, pengeditan, dan penghapusan transaksi berjalan sangat mulus tanpa *reload* halaman.
*   **Keamanan Sandi Tingkat Tinggi**: Kredensial kata sandi pengguna diacak menggunakan algoritma kriptografi standar industri (**BCRYPT**).

---

## 📘 Buku Panduan Fitur Lengkap (User Guidebook)

PocketLedger dilengkapi dengan serangkaian modul finansial terpadu yang dirancang ergonomis dan intuitif:

### 1. Modul Autentikasi & Keamanan Akun
*   **Registrasi & Login Akun**: Formulir masuk dan pendaftaran yang bersih, dilengkapi keterangan *placeholder* berbahasa Indonesia yang jelas serta tombol ikon mata (*toggle password visibility*) untuk melihat atau menyembunyikan kata sandi saat diketik.
*   **Manajemen Kata Sandi**: Melalui menu **Profil Saya**, pengguna dapat memperbarui kata sandi lama secara berkala untuk menjaga keamanan kabinet kas.
*   **Penghapusan Akun Permanen (*Danger Zone*)**: Dilengkapi peringatan konfirmasi ganda (*Double Confirmation Dialog*). Apabila disetujui, sistem akan memusnahkan seluruh riwayat transaksi historis pengguna sebelum menghapus akun secara permanen dari server cloud.

### 2. Modul Manajemen Arus Kas (CRUD Dinamis)
*   **Pencatatan Transaksi Cepat**: Pengguna dapat memasukkan nominal angka, memilih tipe aliran kas (**Pemasukan** atau **Pengeluaran**), menentukan kategori, serta memberikan keterangan rincian transaksi.
*   **Kategori Pintar Berkelanjutan**: Sistem tidak membatasi pilihan kategori pada daftar statis. Ketika pengguna mengetikkan kategori baru (misalnya: *"Investasi Reksadana"* atau *"Perawatan Kendaraan"*), sistem otomatis merekamnya ke dalam riwayat dan menampilkannya pada menu tarik-turun (*dropdown*) di sesi input berikutnya.
*   **Penyuntingan Instan (Tombol EDIT)**: Setiap baris riwayat kas memiliki tombol biru **[EDIT]** yang saat diklik akan memuat ulang data tersebut ke dalam formulir utama. Pengguna dapat memperbaiki nominal atau keterangan yang salah ketik dan menyimpannya secara seketika.
*   **Indikator Anti-Spam (*Loading State*)**: Tombol simpan secara otomatis berubah status menjadi `MENYIMPAN...` saat diproses untuk mencegah duplikasi data transaksi akibat klik berulang.

### 3. Modul Analitik & Pemilahan Cerdas
*   **Visualisasi Multi-Grafik Interaktif (*Chart.js*)**: Pengguna dapat memantau proporsi pengeluaran bulanan melalui 4 pilihan representasi grafik visual yang dapat diganti dengan 1 klik:
    1.  **Donat (*Doughnut Chart*)**: Menampilkan persentase kategori pengeluaran dalam bentuk cincin elegan.
    2.  **Lingkaran (*Pie Chart*)**: Menampilkan porsi pembagian kas secara klasik.
    3.  **Batang (*Bar Chart*)**: Membandingkan besaran pengeluaran antar kategori secara vertikal.
    4.  **Garis (*Line Chart*)**: Menunjukkan tren pengeluaran berdasarkan urutan kategori.
*   **Pemfilteran Periode Fleksibel**:
    *   *Filter Bulan*: Memfilter tampilan riwayat dan grafik berdasarkan bulan tertentu atau menampilkan keseluruhan data historis.
    *   *Filter Rentang Tanggal Kalender*: Memungkinkan pemilahan spesifik berdasarkan rentang hari (misalnya: *Dari Tanggal 10 Juni s/d 15 Juni*).
*   **Pencarian Seketika (*Live Search*)**: Kotak pencarian pintar yang menyaring tabel transaksi secara *real-time* berdasarkan kata kunci keterangan atau nama kategori pada saat huruf diketikkan.

### 4. Modul Ekspor & Pelaporan Profesional
*   **Unduh Excel / CSV**: Tombol **⬇️ CSV (EXCEL)** mengekspor tabel riwayat kas yang sedang tampil menjadi berkas *Comma-Separated Values* (`*.csv`) yang siap diolah lebih lanjut menggunakan rumus di Microsoft Excel atau Google Sheets.
*   **Cetak Laporan PDF Ber-Kop Resmi**: Tombol **📄 CETAK PDF** menghasilkan dokumen berformat A4 rapi berlisensi sistem yang menyertakan judul resmi, tanggal cetak, dan parameter filter aktif.
*   **Rekapitulasi Kalkulasi Otomatis di PDF**: Bagian bawah dokumen laporan PDF dilengkapi tabel ringkasan otomatis:
    *   **TOTAL (PERIODE AKTIF)**: Menjumlahkan seluruh nominal pemasukan dan pengeluaran pada tabel.
    *   **HASIL BERSIH (Surplus / Defisit)**: Menghitung selisih neto (*Pemasukan dikurangi Pengeluaran*). Angka akan tercetak **Hijau (+)** jika arus kas positif/surplus dan **Merah (-)** jika negatif/defisit.

### 5. Modul Utilitas Dasbor & Ergonomi
*   **Pembatas Anggaran Bulanan (*Budget Limiter*)**: Penggeser interaktif (*range slider*) untuk menetapkan batas maksimal pengeluaran bulanan. Kartu statistik di atas dasbor secara otomatis mengalkulasi persentase kuota anggaran yang telah terpakai dan memberi peringatan visual jika mendekati batas.
*   **Kalkulator Retro Terintegrasi**: Komponen kalkulator fungsional bergaya retro di samping tabel riwayat untuk membantu pengguna menghitung total belanjaan dari beberapa nota sebelum angkanya dimasukkan ke dalam sistem kas.
*   **Mode Gelap Adaptif (*Dark Mode*)**: Tombol sakelar **🌙 DARK_MODE** yang secara cerdas merubah skema warna antarmuka dari latar terang menjadi tema gelap kontras tinggi yang sangat nyaman bagi mata saat pengoperasian di malam hari.

---

## 🏛️ Struktur Entitas Basis Data (Database Schema)

Sistem PocketLedger didukung oleh dua tabel utama yang terhubung dalam skema relasional di Cloud MySQL:

```text
+-----------------------+           +--------------------------+
|         users         |           |       transactions       |
+-----------------------+           +--------------------------+
| id (PK)               |<----+     | id (PK)                  |
| username (UNIQUE)     |     +-----| user_id (FK)             |
| password (BCRYPT)     |           | type (Pemasukan/Keluar)  |
| monthly_budget_limit  |           | category                 |
| created_at            |           | amount                   |
+-----------------------+           | description              |
                                    | transaction_date         |
                                    | created_at               |
                                    +--------------------------+
```
*(Catatan: Aturan `FOREIGN KEY` menggunakan `ON DELETE CASCADE` sehingga pembersihan data akun dijamin bersih tanpa meninggalkan data yatim/orphaned records).*

---

## 🎯 Cara Memulai Penggunaan (Quick Start)

1. **Buka Aplikasi**: Kunjungi link cloud resmi **[https://pocket-ledger-nfln.vercel.app](https://pocket-ledger-nfln.vercel.app)** di browser Anda.
2. **Buat Akun**: Klik tautan **Register**, ketikkan *username* unik dan *password* aman pilihan Anda, lalu tekan tombol register.
3. **Atur Anggaran**: Setelah masuk ke Dashboard, geser *slider* batas anggaran di kartu atas sesuai target pengeluaran maksimal Anda bulan ini.
4. **Mulai Mencatat**: Gunakan formulir di sebelah kiri untuk mencatat Pemasukan (gaji/bonus) atau Pengeluaran (makan/tagihan/hiburan).
5. **Pantau & Unduh Laporan**: Gunakan filter bulan atau pencarian untuk meninjau riwayat, lihat proporsi pada grafik visual, lalu klik tombol **CETAK PDF** apabila Anda membutuhkan salinan arsip resmi!

---
*PocketLedger Cloud Web Application © 2026 — Designed & Built with Native PHP & Retro Neo-Brutalist UI.*

<?php
// Vercel Serverless Front Controller
// Mengatur working directory ke root proyek agar semua path include/require berfungsi normal seperti di XAMPP
chdir(__DIR__ . '/..');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routing ke file PHP tujuan
if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    require 'index.php';
} else {
    $file = ltrim($uri, '/');
    if (file_exists($file) && is_file($file)) {
        require $file;
    } else {
        http_response_code(404);
        echo "404 Not Found: File $file tidak ditemukan.";
    }
}
?>

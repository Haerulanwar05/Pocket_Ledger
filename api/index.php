<?php
// Vercel Serverless Front Controller
// Set ke root proyek terlebih dahulu
$root = __DIR__ . '/..';
chdir($root);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    require 'index.php';
} else {
    $file = ltrim($uri, '/');
    if (file_exists($file) && is_file($file)) {
        // Pindah working directory ke folder file tersebut agar relative path (seperti '../config/db.php') berfungsi persis seperti di XAMPP
        $dir = dirname($file);
        if ($dir !== '.' && $dir !== '') {
            chdir($dir);
            require basename($file);
        } else {
            require $file;
        }
    } else {
        http_response_code(404);
        echo "404 Not Found: File $file tidak ditemukan.";
    }
}
?>

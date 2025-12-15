<?php

$lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
   if (strpos(trim($line), '#') === 0) continue; // Skip comments
    putenv(trim($line));
}

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    error_log("Koneksi Database Gagal: " . mysqli_connect_error());
    die("Maaf, server saat ini tidak dapat terhubung ke database."); 
}

mysqli_set_charset($conn, "utf8mb4");
?>
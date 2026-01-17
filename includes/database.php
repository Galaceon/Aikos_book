<?php
$db = mysqli_connect(
    $_ENV['DB_HOST'] ?? '',
    $_ENV['DB_USER'] ?? '', 
    $_ENV['DB_PASS'] ?? '', 
    $_ENV['DB_NAME'] ?? ''
);

if (!$db) {
    error_log('Database connection error');
    header('Location: /error');
    exit;
}
<?php
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') === 0);

$isSecure = !$isLocal && ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);

// Cookie Configuration for a secure session
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $isSecure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();
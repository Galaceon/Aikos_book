<?php

// Generate CSRF token (once per session)
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// CSRF Token Validation
function csrf_validar(): bool {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return true;
    }
    
    $token = $_POST['csrf_token'] ?? '';

    if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }

    return true;
}
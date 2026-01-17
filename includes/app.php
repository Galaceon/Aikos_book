<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

// Add Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'functions.php';
require 'database.php';

// Secure login
require 'csrf.php';
require 'session.php';

// Absolute paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH);
define('BASE_URL', $_ENV['HOST'] ?? '');

// Connect DB
ActiveRecord::setDB($db);
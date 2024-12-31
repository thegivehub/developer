<?php
// config.php

// Environment setting
define('APP_ENV', getenv('APP_ENV') ?: 'development'); // 'development', 'staging', or 'production'

// Load environment-specific .env file if it exists
if (file_exists(__DIR__ . '/.env.' . APP_ENV)) {
    $envFile = parse_ini_file(__DIR__ . '/.env.' . APP_ENV);
    foreach ($envFile as $key => $value) {
        putenv("$key=$value");
    }
}

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'givehub');
define('DB_USER', getenv('DB_USER') ?: 'givehub');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_PORT', getenv('DB_PORT') ?: '3306');

// API Configuration
define('API_VERSION', 'v1');
define('API_URL', getenv('API_URL') ?: 'https://app.thegivehub.org/api');
define('API_RATE_LIMIT', getenv('API_RATE_LIMIT') ?: 1000); // Requests per hour
define('API_TIMEOUT', getenv('API_TIMEOUT') ?: 30); // Seconds

// Security Configuration
define('JWT_SECRET', getenv('JWT_SECRET') ?: 'your_jwt_secret_here');
define('JWT_EXPIRY', getenv('JWT_EXPIRY') ?: 3600); // 1 hour
define('HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_LIFETIME', 7200); // 2 hours

// Stellar Network Configuration
define('STELLAR_NETWORK', getenv('STELLAR_NETWORK') ?: 'testnet'); // 'testnet' or 'public'
define('STELLAR_HORIZON_URL', getenv('STELLAR_HORIZON_URL') ?: 'https://horizon-testnet.stellar.org');
define('GIVEHUB_DISTRIBUTION_ACCOUNT', getenv('GIVEHUB_DISTRIBUTION_ACCOUNT') ?: 'DISTRIBUTION_ACCOUNT_PUBLIC_KEY');

// Email Configuration
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.givehub.org');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);
define('SMTP_USER', getenv('SMTP_USER') ?: 'noreply@givehub.org');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION') ?: 'tls');

// File Upload Configuration
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', [
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);
define('UPLOAD_PATH', __DIR__ . '/uploads');

// Cache Configuration
define('CACHE_DRIVER', getenv('CACHE_DRIVER') ?: 'redis');
define('REDIS_HOST', getenv('REDIS_HOST') ?: 'localhost');
define('REDIS_PORT', getenv('REDIS_PORT') ?: 6379);
define('REDIS_AUTH', getenv('REDIS_AUTH') ?: null);

// Logging Configuration
define('LOG_PATH', __DIR__ . '/logs');
define('LOG_LEVEL', getenv('LOG_LEVEL') ?: 'warning'); // debug, info, warning, error
define('LOG_MAX_FILES', 30);

// Developer Platform Settings
define('DEV_PORTAL_URL', getenv('DEV_PORTAL_URL') ?: 'https://developers.givehub.org');
define('SANDBOX_API_URL', getenv('SANDBOX_API_URL') ?: 'https://sandbox-api.givehub.org');
define('API_DOCS_URL', getenv('API_DOCS_URL') ?: 'https://developers.givehub.org/docs');

// Application URLs
define('APP_URL', getenv('APP_URL') ?: 'https://app.givehub.org');
define('ADMIN_URL', getenv('ADMIN_URL') ?: 'https://admin.givehub.org');
define('CDN_URL', getenv('CDN_URL') ?: 'https://cdn.givehub.org');

// Social Media Integration
define('DISCORD_WEBHOOK_URL', getenv('DISCORD_WEBHOOK_URL') ?: '');
define('SLACK_WEBHOOK_URL', getenv('SLACK_WEBHOOK_URL') ?: '');

// Feature Flags
define('FEATURE_SOROBAN_CONTRACTS', getenv('FEATURE_SOROBAN_CONTRACTS') ?: false);
define('FEATURE_MULTI_CURRENCY', getenv('FEATURE_MULTI_CURRENCY') ?: true);
define('FEATURE_AI_VERIFICATION', getenv('FEATURE_AI_VERIFICATION') ?: false);

// Error Reporting
if (APP_ENV === 'production') {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Time Zone
date_default_timezone_set('UTC');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', APP_ENV === 'production' ? 1 : 0);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);

// Ensure critical directories exist
$requiredDirs = [LOG_PATH, UPLOAD_PATH];
foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

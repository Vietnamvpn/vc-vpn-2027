<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', '/tmp/php_error.log');

session_start();

define('BASE_PATH', dirname(__DIR__));

// 1. Tự động nạp thư viện Composer (nếu có)
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

// 2. Nạp file cấu hình môi trường .env
if (file_exists(BASE_PATH . '/.env')) {
    $envLines = file(BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1], " \t\n\r\0\x0B\"'");
            putenv("{$key}={$val}");
            $_ENV[$key] = $val;
            $_SERVER[$key] = $val;
        }
    }
}

// 3. Tải cấu hình chung và thiết lập môi trường
$appConfig = file_exists(BASE_PATH . '/config/app.php') ? require BASE_PATH . '/config/app.php' : [];
date_default_timezone_set($appConfig['timezone'] ?? 'Asia/Ho_Chi_Minh');

// Ép buộc bật chế độ hiển thị lỗi để phục vụ debug
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 4. Autoload đơn giản cho các class thuộc App\ namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// 5. Nạp bảng định tuyến Routes
$webRoutes = file_exists(BASE_PATH . '/routes/web.php') ? require BASE_PATH . '/routes/web.php' : [];
$apiRoutes = file_exists(BASE_PATH . '/routes/api.php') ? require BASE_PATH . '/routes/api.php' : [];
$routes = array_merge($webRoutes, $apiRoutes);

// 6. Xử lý Request & Router
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$routeKey = $requestMethod . ' ' . $requestUri;

if (array_key_exists($routeKey, $routes)) {
    $handler = $routes[$routeKey];
    $controllerName = "App\\Controllers\\" . $handler[0];
    $methodName = $handler[1];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
            exit;
        }
    }
}

// 7. Xử lý lỗi 404 Not Found
http_response_code(404);
if (strpos($requestUri, '/api/') === 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => false, 'message' => 'API endpoint không tồn tại.'], JSON_UNESCAPED_UNICODE);
} else {
    echo '<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><title>404 Not Found</title></head><body style="display:flex;justify-content:center;align-items:center;height:100vh;font-family:sans-serif;background:#f2f2f7;color:#1c1c1e;"><h1>404 | Trang không tồn tại</h1></body></html>';
}
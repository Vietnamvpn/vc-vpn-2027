<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\SystemLog;

abstract class BaseController
{
    /**
     * Ghi nhật ký thao tác hệ thống vào CSDL (vc_system_logs)
     */
    protected function logActivity(string $action, ?string $description = null): void
    {
        if (!isset($_SESSION['user_id'])) {
            return;
        }

        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] 
            ?? $_SERVER['HTTP_CLIENT_IP'] 
            ?? $_SERVER['REMOTE_ADDR'] 
            ?? '127.0.0.1';

        // Lấy IP đầu tiên nếu qua nhiều Proxy/Cloudflare
        if (str_contains($ipAddress, ',')) {
            $ipAddress = trim(explode(',', $ipAddress)[0]);
        }

        $systemLog = new SystemLog();
        $systemLog->create([
            'user_id'     => (int)$_SESSION['user_id'],
            'action'      => $action,
            'description' => $description,
            'ip_address'  => $ipAddress,
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Render Giao diện View (Tự động cập nhật Session User tươi từ CSDL)
     */
    protected function render(string $view, array $data = []): void
    {
        if (isset($_SESSION['user_id'])) {
            $userModel = new User();
            $currentUser = $userModel->findById((int)$_SESSION['user_id']);

            if ($currentUser) {
                $_SESSION['username']   = $currentUser['username'] ?? $_SESSION['username'] ?? '';
                $_SESSION['full_name']  = $currentUser['full_name'] ?? $_SESSION['full_name'] ?? '';
                $_SESSION['email']      = $currentUser['email'] ?? '';
                $_SESSION['balance']    = $currentUser['balance'] ?? 0;
                $_SESSION['created_at'] = $currentUser['created_at'] ?? '';
                $_SESSION['role']       = $currentUser['role'] ?? 'user';

                $data['currentUser'] = $currentUser;
            } else {
                unset($_SESSION['user_id']);
            }
        }

        extract($data);
        $viewFile = BASE_PATH . '/resources/views/' . str_replace('.', '/', $view) . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View [{$view}] không tồn tại.");
        }
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
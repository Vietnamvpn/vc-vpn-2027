<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\SystemLog;

abstract class BaseController
{
    protected array $settings = [];

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

        if (str_contains($ipAddress, ',')) {
            $ipAddress = trim(explode(',', $ipAddress)[0]);
        }

        if (class_exists('App\Models\SystemLog')) {
            $systemLog = new SystemLog();
            $systemLog->create([
                'user_id'     => (int)$_SESSION['user_id'],
                'action'      => $action,
                'description' => $description,
                'ip_address'  => $ipAddress,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Render Giao diện View (Tự động nạp $settings hệ thống & Session User tươi)
     */
    protected function render(string $view, array $data = []): void
    {
        // Luôn nạp cấu hình CSDL trực tiếp trong render() để không phụ thuộc vào parent::__construct()
        if (empty($this->settings) && class_exists('App\Models\Setting')) {
            $settingModel = new Setting();
            $this->settings = $settingModel->getAllAsKeyValue();
        }

        // Tự động inject biến $settings vào tất cả các View
        if (!isset($data['settings'])) {
            $data['settings'] = $this->settings;
        } else {
            $data['settings'] = array_merge($this->settings, $data['settings']);
        }

        if (isset($_SESSION['user_id'])) {
            if (class_exists('App\Models\User')) {
                $userModel = new User();
                $currentUser = $userModel->findById((int)$_SESSION['user_id']);

                if ($currentUser) {
                    $_SESSION['username']           = $currentUser['username'] ?? $_SESSION['username'] ?? '';
                    $_SESSION['full_name']          = $currentUser['full_name'] ?? $_SESSION['full_name'] ?? '';
                    $_SESSION['email']              = $currentUser['email'] ?? '';
                    $_SESSION['balance']            = $currentUser['balance'] ?? 0;
                    $_SESSION['commission_balance'] = $currentUser['commission_balance'] ?? 0;
                    $_SESSION['created_at']         = $currentUser['created_at'] ?? '';
                    $_SESSION['role']               = $currentUser['role'] ?? 'user';

                    $data['currentUser'] = $currentUser;
                } else {
                    unset($_SESSION['user_id']);
                }
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
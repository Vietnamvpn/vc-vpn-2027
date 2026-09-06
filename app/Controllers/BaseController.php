<?php

namespace App\Controllers;

use App\Models\User;

abstract class BaseController
{
    /**
     * Render Giao diện View (Tự động cập nhật Session User tươi từ CSDL)
     */
    protected function render(string $view, array $data = []): void
    {
        // Kiểm tra và truy vấn lại thông tin tươi nhất từ CSDL nếu đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            $userModel = new User();
            $currentUser = $userModel->findById((int)$_SESSION['user_id']);

            if ($currentUser) {
                // Đồng bộ các trường dữ liệu thực tế từ bảng vc_users vào Session
                $_SESSION['username']   = $currentUser['username'] ?? $_SESSION['username'] ?? '';
                $_SESSION['full_name']  = $currentUser['full_name'] ?? $_SESSION['full_name'] ?? '';
                $_SESSION['email']      = $currentUser['email'] ?? '';
                $_SESSION['balance']    = $currentUser['balance'] ?? 0;
                $_SESSION['created_at'] = $currentUser['created_at'] ?? '';
                $_SESSION['role']       = $currentUser['role'] ?? 'user';

                $data['currentUser'] = $currentUser;
            } else {
                // Nếu tài khoản đã bị xóa khỏi CSDL, hủy session
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

    /**
     * Trả về dữ liệu dạng JSON cho API / AJAX
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Chuyển hướng URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
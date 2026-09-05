<?php

namespace App\Controllers;

abstract class BaseController
{
    /**
     * Render Giao diện View
     */
    protected function render(string $view, array $data = []): void
    {
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
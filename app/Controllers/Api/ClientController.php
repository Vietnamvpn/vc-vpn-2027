<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class ClientController extends BaseController
{
    public function subscribe(): void
    {
        $token = trim($_GET['token'] ?? '');

        if (empty($token)) {
            $this->json(['status' => false, 'message' => 'Token đăng ký không hợp lệ.'], 400);
        }

        // Cấu hình mẫu danh sách node cho ứng dụng Client (V2Ray / Sing-box / Clash)
        $configContent = "vless://11111111-2222-3333-4444-555555555555@127.0.0.1:443?type=tcp&security=tls#VC-VPN-Node-1";

        header('Content-Type: text/plain; charset=utf-8');
        echo base64_encode($configContent);
        exit;
    }
}
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Subscription;

class ClientController extends BaseController
{
    public function subscribe(): void
    {
        // Nhận uuid hoặc token từ URL query parameter
        $uuid = trim($_GET['uuid'] ?? $_GET['token'] ?? '');

        if (empty($uuid)) {
            $this->json(['status' => false, 'message' => 'Mã đăng ký (UUID) không hợp lệ.'], 400);
            return;
        }

        if (class_exists('App\Models\Subscription')) {
            $subModel = new Subscription();
            $subscription = $subModel->findByUuid($uuid);

            if (!$subscription || ($subscription['status'] ?? '') !== 'active') {
                header('HTTP/1.1 403 Forbidden');
                echo "Gói đăng ký không tồn tại hoặc đã hết hạn.";
                exit;
            }
        }

        // Cấu hình mẫu danh sách node VPN cho ứng dụng Client (V2Ray / Sing-box / Clash) dựa trên UUID
        $configContent = "vless://{$uuid}@127.0.0.1:443?type=tcp&security=tls#VC-VPN-Node-1";

        header('Content-Type: text/plain; charset=utf-8');
        echo base64_encode($configContent);
        exit;
    }
}
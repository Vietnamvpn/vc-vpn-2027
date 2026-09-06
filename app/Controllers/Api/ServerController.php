<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class ServerController extends BaseController
{
    private function verifyNodeKey(): void
    {
        $nodeKey = $_SERVER['HTTP_X_NODE_KEY'] ?? $_POST['node_key'] ?? '';
        $serverKey = getenv('NODE_SECRET_KEY') ?: 'vc_secret_key_2027';

        if (empty($nodeKey) || $nodeKey !== $serverKey) {
            $this->json(['status' => false, 'message' => 'Xác thực Node thất bại.'], 401);
        }
    }

    public function checkin(): void
    {
        $this->verifyNodeKey();

        $nodeId = $_POST['node_id'] ?? null;
        $status = $_POST['status'] ?? 'online';

        $this->json([
            'status' => true,
            'message' => 'Node checkin thành công.',
            'data' => [
                'node_id' => $nodeId,
                'server_time' => time()
            ]
        ]);
    }

    public function users(): void
    {
        $this->verifyNodeKey();

        // Trả về danh sách tài khoản active để Node đồng bộ
        $users = [
            [
                'id' => 1,
                'uuid' => '11111111-2222-3333-4444-555555555555',
                'speed_limit' => 0,
                'device_limit' => 5
            ]
        ];

        $this->json([
            'status' => true,
            'data' => $users
        ]);
    }

    public function pushTraffic(): void
    {
        $this->verifyNodeKey();

        $rawInput = file_get_contents('php://input');
        $trafficData = json_decode($rawInput, true);

        $this->json([
            'status' => true,
            'message' => 'Báo cáo dung lượng thành công.'
        ]);
    }
}
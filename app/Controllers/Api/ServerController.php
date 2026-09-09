<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Subscription;
use App\Models\Server;

class ServerController extends BaseController
{
    private function verifyNodeKey(): void
    {
        $nodeKey = $_SERVER['HTTP_X_NODE_KEY'] ?? $_POST['node_key'] ?? '';
        $serverKey = getenv('NODE_SECRET_KEY') ?: 'vc_secret_key_2027';

        if (empty($nodeKey) || $nodeKey !== $serverKey) {
            $this->json(['status' => false, 'message' => 'Xác thực Node thất bại.'], 401);
            exit;
        }
    }

    public function checkin(): void
    {
        $this->verifyNodeKey();

        $nodeId = $_POST['node_id'] ?? null;
        if ($nodeId) {
            $serverModel = new Server();
            $serverModel->updateLastCheckin($nodeId);
        }

        $this->json([
            'status' => true,
            'message' => 'Node checkin thành công.',
            'data' => ['server_time' => time()]
        ]);
    }

    public function users(): void
    {
        $this->verifyNodeKey();

        $subModel = new Subscription();
        $activeSubs = $subModel->getAllActiveUsers();

        $users = array_map(function($sub) {
            return [
                'id' => $sub['id'],
                'uuid' => $sub['uuid'],
                'u' => $sub['upload'],
                'd' => $sub['download'],
                'transfer_enable' => $sub['transfer_enable']
            ];
        }, $activeSubs);

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

        if (is_array($trafficData)) {
            $subModel = new Subscription();
            foreach ($trafficData as $item) {
                if (!empty($item['uuid'])) {
                    $u = (int)($item['u'] ?? 0);
                    $d = (int)($item['d'] ?? 0);
                    $subModel->addTraffic($item['uuid'], $u, $d);
                }
            }
        }

        $this->json([
            'status' => true,
            'message' => 'Cập nhật dung lượng thành công.'
        ]);
    }
}
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Subscription;
use App\Models\NodeInbound;
use App\Models\VpnPlan;
use App\Services\VpnService;

class ClientController extends BaseController
{
    public function subscribe(): void
    {
        $uuid = trim($_GET['uuid'] ?? $_GET['token'] ?? '');

        if (empty($uuid)) {
            $this->json(['status' => false, 'message' => 'Mã đăng ký (UUID) không hợp lệ.'], 400);
            return;
        }

        $subModel = new Subscription();
        $subscription = $subModel->findByUuid($uuid);

        if (!$subscription || ($subscription['status'] ?? '') !== 'active' || strtotime($subscription['end_date']) < time()) {
            header('HTTP/1.1 403 Forbidden');
            echo "Gói đăng ký không tồn tại, đã bị khóa hoặc hết hạn.";
            exit;
        }

        // Lấy danh sách group_id (mảng) từ gói cước tương ứng với gói đăng ký
        $groupIds = [];
        if (class_exists('App\Models\VpnPlan') && !empty($subscription['plan_id'])) {
            $planModel = new VpnPlan();
            $plan = $planModel->find((int)$subscription['plan_id']);
            if ($plan) {
                $groupIds = json_decode($plan['group_id'] ?? '[]', true);
                if (!is_array($groupIds)) {
                    $groupIds = !empty($plan['group_id']) ? [(int)$plan['group_id']] : [];
                }
            }
        }

        // Lấy danh sách Node Inbounds đang hoạt động thuộc các nhóm máy chủ của gói cước
        $nodeInboundModel = new NodeInbound();
        $inbounds = $nodeInboundModel->getAllActiveWithServer($groupIds);

        $vpnService = new VpnService();
        $links = [];

        foreach ($inbounds as $inbound) {
            $link = $vpnService->buildLink($inbound, $uuid);
            if ($link) {
                $links[] = $link;
            }
        }

        // Nếu chưa có giao thức nào trong database hoặc không có node active
        if (empty($links)) {
            header('Content-Type: text/plain; charset=utf-8');
            echo "Chưa có giao thức nào được cấp.";
            exit;
        }

        // Nhân đôi node đầu tiên và đổi tên thành "Cập nhật thường xuyên" đưa lên vị trí đầu tiên
        $infoLink = $links[0];
        $hashPos = strpos($infoLink, '#');
        $newName = rawurlencode('Cập Nhật Thường Xuyên');
        if ($hashPos !== false) {
            $infoLink = substr($infoLink, 0, $hashPos + 1) . $newName;
        } else {
            $infoLink .= '#' . $newName;
        }
        array_unshift($links, $infoLink);

        // Trả về Header thông tin dung lượng cho App Client
        $upload = $subscription['upload'] ?? 0;
        $download = $subscription['download'] ?? 0;
        $total = $subscription['transfer_enable'] ?? 0;
        $expire = strtotime($subscription['end_date']);

        header('Content-Type: text/plain; charset=utf-8');
        header("Subscription-Userinfo: upload={$upload}; download={$download}; total={$total}; expire={$expire}");

        echo base64_encode(implode("\n", $links));
        exit;
    }
}
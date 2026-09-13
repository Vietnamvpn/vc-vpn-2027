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

        // Trả về Header thông tin dung lượng cho App Client
        $upload = $subscription['upload'] ?? 0;
        $download = $subscription['download'] ?? 0;
        $total = $subscription['transfer_enable'] ?? 0;
        $expire = strtotime($subscription['end_date']);

        // Hàm quy đổi đơn vị dung lượng tự động (MB / GB / TB) từ MB trở lên
        $formatBytes = function (int|float $bytes): string {
            if ($bytes >= 1099511627776) {
                return round($bytes / 1099511627776, 2) . ' TB';
            }
            if ($bytes >= 1073741824) {
                return round($bytes / 1073741824, 2) . ' GB';
            }
            return round($bytes / 1048576, 2) . ' MB';
        };

        // Nhân bản node đầu tiên để tạo 3 node thông tin: Cập nhật, Hạn dùng và Dung lượng
        $baseLink = $links[0];
        $hashPos = strpos($baseLink, '#');
        $cleanLink = ($hashPos !== false) ? substr($baseLink, 0, $hashPos) : $baseLink;

        $nodeUpdate = $cleanLink . '#' . rawurlencode('Cập Nhật Thường Xuyên');
        $nodeExpire = $cleanLink . '#' . rawurlencode('HDS: ' . date('d/m/Y', $expire));

        $usedStr = $formatBytes($upload + $download);
        if ($total > 0) {
            $totalStr = $formatBytes($total);
            $nodeData = $cleanLink . '#' . rawurlencode("Data: {$usedStr} / {$totalStr}");
        } else {
            $nodeData = $cleanLink . '#' . rawurlencode("Data: {$usedStr} / KGH");
        }

        array_unshift($links, $nodeUpdate, $nodeExpire, $nodeData);

        header('Content-Type: text/plain; charset=utf-8');
        header("Subscription-Userinfo: upload={$upload}; download={$download}; total={$total}; expire={$expire}");

        echo base64_encode(implode("\n", $links));
        exit;
    }
}
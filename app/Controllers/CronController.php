<?php

namespace App\Controllers;

use App\Models\Subscription;
use App\Models\VpnPlan;
use App\Models\User;
use App\Models\NodeTask;
use App\Models\Setting;
use App\Services\MailService;

class CronController extends BaseController
{
    /**
     * Tự động quét và xử lý các gói cước hết hạn, hết data, hoặc sắp hết hạn
     */
    public function checkSubscriptions(): void
    {
        // 1. Kiểm tra Secret Key từ tham số URL (?key=VC_VPN_CRON_2027_SECRET)
        $settingModel = new Setting();
        $cronSecret = $settingModel->get('cron_secret_key', 'VC_VPN_CRON_2027_SECRET');
        $providedKey = $_GET['key'] ?? '';

        if (!hash_equals($cronSecret, $providedKey)) {
            $this->json(['status' => false, 'message' => 'Truy cập không hợp lệ.'], 403);
            return;
        }

        $subscriptionModel = new Subscription();
        $nodeTaskModel     = new NodeTask();
        $mailService       = new MailService();

        $now = date('Y-m-d H:i:s');
        $stats = [
            'expired'       => 0,
            'data_exceeded' => 0,
            'expiring_soon' => 0
        ];

        // -------------------------------------------------------------
        // XỬ LÝ 1: CÁC GÓI ACTIVE ĐÃ HẾT HẠN (end_date <= NOW)
        // -------------------------------------------------------------
        $sqlExpired = "
            SELECT s.*, u.email, u.username AS user_name, p.group_id, p.name AS plan_name
            FROM `vc_subscriptions` s
            INNER JOIN `vc_users` u ON s.user_id = u.id
            INNER JOIN `vc_vpn_plans` p ON s.plan_id = p.id
            WHERE s.status = 'active' AND s.end_date <= :now
        ";
        $stmt = self::$db->prepare($sqlExpired);
        $stmt->execute(['now' => $now]);
        $expiredSubs = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        foreach ($expiredSubs as $sub) {
            // Cập nhật trạng thái trong Database
            $subscriptionModel->update($sub['id'], [
                'status'     => 'expired',
                'updated_at' => $now
            ]);

            // Gửi Task toggle_user khóa tài khoản xuống các máy chủ thuộc nhóm của gói cước
            if (!empty($sub['group_id'])) {
                $nodeTaskModel->createTasksForGroup((int)$sub['group_id'], 'toggle_user', [
                    'username' => 'sub_' . $sub['id'],
                    'status'   => 'disabled'
                ]);
            }

            // Gửi Email thông báo
            if (!empty($sub['email'])) {
                $mailService->send($sub['email'], 'Tài khoản VPN của bạn đã hết hạn', 'subscriptions.expired', [
                    'username'  => $sub['user_name'],
                    'plan_name' => $sub['plan_name'],
                    'end_date'  => $sub['end_date']
                ]);
            }

            $stats['expired']++;
        }

        // -------------------------------------------------------------
        // XỬ LÝ 2: CÁC GÓI ACTIVE ĐÃ HẾT DUNG LƯỢNG ((upload + download) >= transfer_enable)
        // -------------------------------------------------------------
        $sqlDataExceeded = "
            SELECT s.*, u.email, u.username AS user_name, p.group_id, p.name AS plan_name
            FROM `vc_subscriptions` s
            INNER JOIN `vc_users` u ON s.user_id = u.id
            INNER JOIN `vc_vpn_plans` p ON s.plan_id = p.id
            WHERE s.status = 'active' 
              AND s.transfer_enable > 0 
              AND (s.upload + s.download) >= s.transfer_enable
        ";
        $stmt = self::$db->prepare($sqlDataExceeded);
        $stmt->execute();
        $dataExceededSubs = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        foreach ($dataExceededSubs as $sub) {
            // Cập nhật trạng thái trong Database
            $subscriptionModel->update($sub['id'], [
                'status'     => 'suspended',
                'updated_at' => $now
            ]);

            // Gửi Task toggle_user khóa tài khoản xuống các máy chủ thuộc nhóm của gói cước
            if (!empty($sub['group_id'])) {
                $nodeTaskModel->createTasksForGroup((int)$sub['group_id'], 'toggle_user', [
                    'username' => 'sub_' . $sub['id'],
                    'status'   => 'disabled'
                ]);
            }

            // Gửi Email thông báo
            if (!empty($sub['email'])) {
                $mailService->send($sub['email'], 'Tài khoản VPN của bạn đã hết dung lượng', 'subscriptions.data-exceeded', [
                    'username'  => $sub['user_name'],
                    'plan_name' => $sub['plan_name']
                ]);
            }

            $stats['data_exceeded']++;
        }

        // -------------------------------------------------------------
        // XỬ LÝ 3: CÁC GÓI SẮP HẾT HẠN (Còn dưới 3 ngày)
        // -------------------------------------------------------------
        $threeDaysLater = date('Y-m-d H:i:s', strtotime('+3 days'));
        $sqlExpiringSoon = "
            SELECT s.*, u.email, u.username AS user_name, p.name AS plan_name
            FROM `vc_subscriptions` s
            INNER JOIN `vc_users` u ON s.user_id = u.id
            INNER JOIN `vc_vpn_plans` p ON s.plan_id = p.id
            WHERE s.status = 'active' 
              AND s.end_date > :now 
              AND s.end_date <= :three_days
        ";
        $stmt = self::$db->prepare($sqlExpiringSoon);
        $stmt->execute([
            'now'        => $now,
            'three_days' => $threeDaysLater
        ]);
        $expiringSoonSubs = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        foreach ($expiringSoonSubs as $sub) {
            if (!empty($sub['email'])) {
                $mailService->send($sub['email'], 'Cảnh báo: Tài khoản VPN sắp hết hạn', 'subscriptions.expiring-soon', [
                    'username'  => $sub['user_name'],
                    'plan_name' => $sub['plan_name'],
                    'end_date'  => $sub['end_date']
                ]);
            }
            $stats['expiring_soon']++;
        }

        $this->json([
            'status'  => true,
            'message' => 'Hoàn tất tiến trình tự động quét gói cước.',
            'data'    => $stats
        ]);
    }
}
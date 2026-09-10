<?php

namespace App\Models;

class Subscription extends BaseModel
{
    protected string $table = 'vc_subscriptions';

    /**
     * Lấy danh sách toàn bộ đăng ký kèm thông tin user và gói cước (có hỗ trợ lọc theo user_id)
     */
    public function allWithDetails(?int $userId = null): array
    {
        $sql = "
            SELECT s.*, 
                   u.username, u.email, 
                   p.name AS plan_name, p.code AS plan_code, p.device_limit
            FROM `{$this->table}` s
            LEFT JOIN `vc_users` u ON s.user_id = u.id
            LEFT JOIN `vc_vpn_plans` p ON s.plan_id = p.id
        ";

        $params = [];
        if ($userId !== null && $userId > 0) {
            $sql .= " WHERE s.user_id = :user_id";
            $params['user_id'] = $userId;
        }

        $sql .= " ORDER BY s.id DESC";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Lấy chi tiết gói đăng ký theo ID kèm thông tin liên quan và giới hạn thiết bị (device_limit)
     */
    public function findWithDetails(int $id): ?array
    {
        $stmt = self::$db->prepare("
            SELECT s.*, 
                   u.username, u.email, 
                   p.name AS plan_name, p.code AS plan_code, p.device_limit, p.group_id,
                   o.order_code
            FROM `{$this->table}` s
            LEFT JOIN `vc_users` u ON s.user_id = u.id
            LEFT JOIN `vc_vpn_plans` p ON s.plan_id = p.id
            LEFT JOIN `vc_orders` o ON s.order_id = o.id
            WHERE s.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getByUserId(int $userId): array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `user_id` = :user_id ORDER BY `id` DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Tìm kiếm gói đăng ký bằng UUID duy nhất
     */
    public function findByUuid(string $uuid): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `uuid` = :uuid LIMIT 1");
        $stmt->execute(['uuid' => $uuid]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy danh sách tài khoản đang kích hoạt để gửi về cho Node VPS đồng bộ
     */
    public function getAllActiveUsers(): array
    {
        $stmt = self::$db->prepare("
            SELECT id, uuid, upload, download, transfer_enable 
            FROM `{$this->table}` 
            WHERE `status` = 'active' AND `end_date` > NOW()
        ");
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Cộng dồn dung lượng Upload/Download, cập nhật IP sử dụng và số lượng thiết bị theo ID gói cước (sub_X)
     */
    public function addTrafficById(int $id, int $u, int $d, ?string $lastIp = null, ?int $ipCount = null): bool
    {
        $extraSql = "";
        $params = [
            'u'  => $u,
            'd'  => $d,
            'id' => $id
        ];

        if ($lastIp !== null) {
            $extraSql .= ", `last_used_ip` = :last_ip";
            $params['last_ip'] = $lastIp;
        }

        if ($ipCount !== null) {
            $extraSql .= ", `online_devices` = :ip_count";
            $params['ip_count'] = $ipCount;
        }

        $sql = "
            UPDATE `{$this->table}` 
            SET `upload` = `upload` + :u, 
                `download` = `download` + :d 
                {$extraSql},
                `updated_at` = NOW() 
            WHERE `id` = :id
        ";

        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Cộng dồn dung lượng Upload/Download, cập nhật IP sử dụng và số lượng thiết bị theo UUID
     */
    public function addTrafficByUuid(string $uuid, int $u, int $d, ?string $lastIp = null, ?int $ipCount = null): bool
    {
        $extraSql = "";
        $params = [
            'u'    => $u,
            'd'    => $d,
            'uuid' => $uuid
        ];

        if ($lastIp !== null) {
            $extraSql .= ", `last_used_ip` = :last_ip";
            $params['last_ip'] = $lastIp;
        }

        if ($ipCount !== null) {
            $extraSql .= ", `online_devices` = :ip_count";
            $params['ip_count'] = $ipCount;
        }

        $sql = "
            UPDATE `{$this->table}` 
            SET `upload` = `upload` + :u, 
                `download` = `download` + :d 
                {$extraSql},
                `updated_at` = NOW() 
            WHERE `uuid` = :uuid
        ";

        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Giữ hàm cũ để đảm bảo tính tương thích
     */
    public function addTraffic(string $uuid, int $u, int $d): bool
    {
        return $this->addTrafficByUuid($uuid, $u, $d);
    }

    /**
     * Tìm kiếm gói đăng ký theo ID đơn hàng (order_id)
     */
    public function findByOrderId(int $orderId): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `order_id` = :order_id LIMIT 1");
        $stmt->execute(['order_id' => $orderId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
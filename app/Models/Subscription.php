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
                   p.name AS plan_name, p.code AS plan_code
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
     * Lấy chi tiết gói đăng ký theo ID kèm thông tin liên quan
     */
    public function findWithDetails(int $id): ?array
    {
        $stmt = self::$db->prepare("
            SELECT s.*, 
                   u.username, u.email, 
                   p.name AS plan_name, p.code AS plan_code,
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
     * Cộng dồn dung lượng Upload và Download từ Node VPS báo về theo UUID
     */
    public function addTraffic(string $uuid, int $u, int $d): bool
    {
        $stmt = self::$db->prepare("
            UPDATE `{$this->table}` 
            SET `upload` = `upload` + :u, 
                `download` = `download` + :d, 
                `updated_at` = NOW() 
            WHERE `uuid` = :uuid
        ");
        return $stmt->execute([
            'u'    => $u,
            'd'    => $d,
            'uuid' => $uuid
        ]);
    }
}
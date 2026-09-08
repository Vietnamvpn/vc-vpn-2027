<?php

namespace App\Models;

class Subscription extends BaseModel
{
    protected string $table = 'vc_subscriptions';

    /**
     * Lấy danh sách toàn bộ đăng ký kèm thông tin user và gói cước
     */
    public function allWithDetails(): array
    {
        $stmt = self::$db->prepare("
            SELECT s.*, 
                   u.username, u.email, 
                   p.name AS plan_name, p.code AS plan_code
            FROM `{$this->table}` s
            LEFT JOIN `vc_users` u ON s.user_id = u.id
            LEFT JOIN `vc_vpn_plans` p ON s.plan_id = p.id
            ORDER BY s.id DESC
        ");
        $stmt->execute();
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
}
<?php

namespace App\Models;

class Payment extends BaseModel
{
    protected string $table = 'vc_payments';

    /**
     * Lấy toàn bộ danh sách thanh toán kèm thông tin người dùng và mã đơn hàng
     */
    public function allWithDetails(): array
    {
        $stmt = self::$db->prepare("
            SELECT p.*, 
                   u.username, u.email, 
                   o.order_code
            FROM `{$this->table}` p
            LEFT JOIN `vc_users` u ON p.user_id = u.id
            LEFT JOIN `vc_orders` o ON p.order_id = o.id
            ORDER BY p.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Lấy chi tiết 1 giao dịch thanh toán theo ID kèm thông tin liên quan
     */
    public function findWithDetails(int $id): ?array
    {
        $stmt = self::$db->prepare("
            SELECT p.*, 
                   u.username, u.email, 
                   o.order_code
            FROM `{$this->table}` p
            LEFT JOIN `vc_users` u ON p.user_id = u.id
            LEFT JOIN `vc_orders` o ON p.order_id = o.id
            WHERE p.id = :id
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
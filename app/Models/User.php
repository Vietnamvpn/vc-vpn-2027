<?php

namespace App\Models;

class User extends BaseModel
{
    protected string $table = 'vc_users';

    /**
     * Tìm người dùng theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm người dùng theo Username hoặc Email
     */
    public function findByUsernameOrEmail(string $identifier): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `username` = :username OR `email` = :email LIMIT 1");
        $stmt->execute([
            'username' => $identifier,
            'email'    => $identifier
        ]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Đếm tổng số tất cả tài khoản trong hệ thống
     */
    public function countAll(): int
    {
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM `{$this->table}`");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    /**
     * Đếm số tài khoản mới đăng ký trong ngày hôm nay
     */
    public function countToday(): int
    {
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM `{$this->table}` WHERE DATE(`created_at`) = CURDATE()");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }
}
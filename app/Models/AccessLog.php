<?php

namespace App\Models;

class AccessLog extends BaseModel
{
    protected string $table = 'vc_access_logs';

    /**
     * Lấy toàn bộ nhật ký truy cập kèm thông tin tài khoản
     */
    public function allWithUser(): array
    {
        $stmt = self::$db->prepare("
            SELECT al.*, u.username, u.email
            FROM `{$this->table}` al
            LEFT JOIN `vc_users` u ON al.user_id = u.id
            ORDER BY al.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }
}
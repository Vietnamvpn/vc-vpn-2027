<?php

namespace App\Models;

class SystemLog extends BaseModel
{
    protected string $table = 'vc_system_logs';

    /**
     * Lấy toàn bộ nhật ký hệ thống kèm thông tin người thực hiện
     */
    public function allWithUser(): array
    {
        $stmt = self::$db->prepare("
            SELECT sl.*, u.username
            FROM `{$this->table}` sl
            LEFT JOIN `vc_users` u ON sl.user_id = u.id
            ORDER BY sl.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }
}
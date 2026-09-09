<?php

namespace App\Models;

class NodeTask extends BaseModel
{
    protected string $table = 'vc_node_tasks';

    /**
     * Lấy danh sách các task đang chờ xử lý (pending) theo server_id
     */
    public function getPendingTasks(int $serverId): array
    {
        $sql = "
            SELECT id, action, payload 
            FROM `{$this->table}` 
            WHERE `server_id` = :server_id AND `status` = 'pending' 
            ORDER BY `id` ASC
        ";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['server_id' => $serverId]);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Cập nhật trạng thái của Task sau khi VPS xử lý xong
     */
    public function updateStatus(int $taskId, string $status, ?string $errorMsg = null): bool
    {
        $sql = "
            UPDATE `{$this->table}` 
            SET `status` = :status, 
                `attempts` = `attempts` + 1, 
                `updated_at` = NOW() 
            WHERE `id` = :id
        ";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id'     => $taskId
        ]);
    }

    /**
     * Khởi tạo task mới để gửi xuống máy chủ VPS
     */
    public function create(int $serverId, string $action, array $payload): bool
    {
        $sql = "
            INSERT INTO `{$this->table}` (`server_id`, `action`, `payload`, `status`, `created_at`) 
            VALUES (:server_id, :action, :payload, 'pending', NOW())
        ";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            'server_id' => $serverId,
            'action'    => $action,
            'payload'   => json_encode($payload, JSON_UNESCAPED_UNICODE)
        ]);
    }
}
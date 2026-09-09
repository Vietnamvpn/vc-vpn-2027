<?php

namespace App\Models;

class NodeInbound extends BaseModel
{
    protected string $table = 'vc_node_inbounds';

    /**
     * Lấy danh sách tất cả Node Inbound đang hoạt động kèm thông tin Máy chủ (Server)
     */
    public function getAllActiveWithServer(): array
    {
        $sql = "SELECT i.*, s.name AS server_name, s.ip_address 
                FROM {$this->table} i
                INNER JOIN vc_servers s ON i.server_id = s.id
                WHERE i.status = 'active' AND s.status = 'active'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}
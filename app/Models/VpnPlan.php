<?php

namespace App\Models;

class VpnPlan extends BaseModel
{
    protected string $table = 'vc_vpn_plans';

    public function getAllActive(): array
    {
        $stmt = self::$db->query("SELECT * FROM `{$this->table}` WHERE `status` = 'active' ORDER BY `price` ASC");
        return $stmt->fetchAll() ?: [];
    }

    public function getAllWithGroup(): array
    {
        $sql = "SELECT p.*, g.name AS group_name 
                FROM `{$this->table}` p 
                LEFT JOIN `vc_server_groups` g ON p.group_id = g.id 
                ORDER BY p.id DESC";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll() ?: [];
    }
}
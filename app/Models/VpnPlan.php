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
}
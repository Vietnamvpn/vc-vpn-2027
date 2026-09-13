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
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `id` DESC";
        $stmt = self::$db->query($sql);
        $plans = $stmt->fetchAll() ?: [];

        if (empty($plans)) {
            return [];
        }

        // Lấy tất cả nhóm máy chủ để ghép tên
        $groupStmt = self::$db->query("SELECT `id`, `name` FROM `vc_server_groups`");
        $groupsList = $groupStmt->fetchAll(\PDO::FETCH_KEY_PAIR) ?: [];

        foreach ($plans as &$plan) {
            $groupIds = json_decode($plan['group_id'] ?? '[]', true);
            if (!is_array($groupIds)) {
                $groupIds = !empty($plan['group_id']) ? [(int)$plan['group_id']] : [];
            }

            $names = [];
            foreach ($groupIds as $gId) {
                if (isset($groupsList[$gId])) {
                    $names[] = $groupsList[$gId];
                }
            }

            $plan['group_name'] = !empty($names) ? implode(', ', $names) : 'Chưa chọn nhóm';
            $plan['group_ids']  = $groupIds;
        }

        return $plans;
    }
}
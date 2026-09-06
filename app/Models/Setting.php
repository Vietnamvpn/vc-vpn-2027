<?php

namespace App\Models;

class Setting extends BaseModel
{
    protected string $table = 'vc_settings';

    public function getByKey(string $key): ?string
    {
        $stmt = self::$db->prepare("SELECT `value` FROM `{$this->table}` WHERE `key` = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetch();
        return $result['value'] ?? null;
    }
}
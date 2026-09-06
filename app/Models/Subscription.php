<?php

namespace App\Models;

class Subscription extends BaseModel
{
    protected string $table = 'vc_subscriptions';

    public function getByUserId(int $userId): array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `user_id` = :user_id ORDER BY `id` DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }
}
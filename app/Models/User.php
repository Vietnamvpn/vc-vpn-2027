<?php

namespace App\Models;

class User extends BaseModel
{
    protected string $table = 'vc_users';

    public function findByUsernameOrEmail(string $identifier): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `username` = :identifier OR `email` = :identifier LIMIT 1");
        $stmt->execute(['identifier' => $identifier]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
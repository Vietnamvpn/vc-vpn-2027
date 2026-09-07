<?php

namespace App\Models;

class User extends BaseModel
{
    protected string $table = 'vc_users';

    public function findById(int $id): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByUsernameOrEmail(string $identifier): ?array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `username` = :username OR `email` = :email LIMIT 1");
        $stmt->execute([
            'username' => $identifier,
            'email'    => $identifier
        ]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function countAll(): int
    {
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM `{$this->table}`");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function countToday(): int
    {
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM `{$this->table}` WHERE DATE(`created_at`) = CURDATE()");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function getAll(string $search = '', string $role = '', string $status = ''): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (`username` LIKE :search OR `email` LIKE :search OR `full_name` LIKE :search OR `phone` LIKE :search)";
            $params['search'] = "%{$search}%";
        }

        if (!empty($role)) {
            $sql .= " AND `role` = :role";
            $params['role'] = $role;
        }

        if (!empty($status)) {
            $sql .= " AND `status` = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY `id` DESC";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll() ?: [];
    }

    public function create(array $data): bool
    {
        $stmt = self::$db->prepare("
            INSERT INTO `{$this->table}` (`username`, `email`, `password_hash`, `full_name`, `phone`, `role`, `status`, `balance`, `commission_balance`, `ref_code`, `created_at`)
            VALUES (:username, :email, :password_hash, :full_name, :phone, :role, :status, :balance, :commission_balance, :ref_code, NOW())
        ");
        return $stmt->execute([
            'username'           => $data['username'],
            'email'              => $data['email'],
            'password_hash'      => $data['password_hash'],
            'full_name'          => $data['full_name'] ?? null,
            'phone'              => $data['phone'] ?? null,
            'role'               => $data['role'] ?? 'user',
            'status'             => $data['status'] ?? 'active',
            'balance'            => $data['balance'] ?? 0.00,
            'commission_balance' => $data['commission_balance'] ?? 0.00,
            'ref_code'           => $data['ref_code'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            $fields[] = "`{$key}` = :{$key}";
            $params[$key] = $value;
        }

        if (empty($fields)) return false;

        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $fields) . ", `updated_at` = NOW() WHERE `id` = :id";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = self::$db->prepare("DELETE FROM `{$this->table}` WHERE `id` = :id");
        return $stmt->execute(['id' => $id]);
    }
}
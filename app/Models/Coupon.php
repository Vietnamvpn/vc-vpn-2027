<?php

namespace App\Models;

class Coupon extends BaseModel
{
    protected string $table = 'vc_coupons';

    public function findByCode(string $code): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE code = ? LIMIT 1");
        $stmt->execute([$code]);
        $result = $stmt->fetch();

        return $result ?: null;
    }
}
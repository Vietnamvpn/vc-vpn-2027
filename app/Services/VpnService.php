<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;

class VpnService
{
    /**
     * Tạo UUID ngẫu nhiên chuẩn v4 cho tài khoản VPN
     */
    public function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Tạo Token đăng ký (Subscription Token) ngẫu nhiên
     */
    public function generateSubscribeToken(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Quy đổi dung lượng Bytes sang GB
     */
    public function bytesToGb(int $bytes): float
    {
        return round($bytes / (1024 * 1024 * 1024), 2);
    }

    /**
     * Quy đổi GB sang Bytes
     */
    public function gbToBytes(float $gb): int
    {
        return (int)($gb * 1024 * 1024 * 1024);
    }

    /**
     * Tạo cấu hình liên kết VLESS cho ứng dụng Client
     */
    public function buildVlessUrl(string $uuid, string $serverHost, int $port, string $nodeName, string $network = 'tcp', string $security = 'tls'): string
    {
        return "vless://{$uuid}@{$serverHost}:{$port}?type={$network}&security={$security}#" . rawurlencode($nodeName);
    }
}
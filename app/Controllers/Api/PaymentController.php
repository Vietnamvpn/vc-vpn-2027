<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class PaymentController extends BaseController
{
    public function webhook(): void
    {
        $rawInput = file_get_contents('php://input');
        $payload = json_decode($rawInput, true) ?: $_POST;

        if (empty($payload)) {
            $this->json(['status' => false, 'message' => 'Dữ liệu Webhook không hợp lệ.'], 400);
        }

        // Logic xử lý cập nhật số dư / duyệt đơn hàng tự động từ cổng thanh toán tại đây

        $this->json([
            'status' => true,
            'message' => 'Xử lý webhook thanh toán thành công.'
        ]);
    }
}
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\OrderService;
use App\Services\PaymentService;

class PaymentController extends BaseController
{
    public function webhook(): void
    {
        // Nhận dữ liệu linh hoạt từ JSON Body hoặc Form POST
        $rawInput = file_get_contents('php://input');
        $payload  = json_decode($rawInput, true);

        if (empty($payload)) {
            $payload = $_POST;
        }

        if (empty($payload)) {
            $this->json(['status' => false, 'message' => 'Dữ liệu Webhook không hợp lệ.'], 400);
            return;
        }

        // 1. Kiểm tra Secret Token
        $config = require __DIR__ . '/../../../config/app.php';
        $expectedSecret = $config['macrodroid_secret'] ?? '';
        $providedSecret = $payload['secret'] ?? $_SERVER['HTTP_X_MACRODROID_SECRET'] ?? '';

        if (!empty($expectedSecret) && !hash_equals($expectedSecret, $providedSecret)) {
            $this->json(['status' => false, 'message' => 'Mã xác thực Webhook không hợp lệ.'], 403);
            return;
        }

        $content = trim($payload['content'] ?? $payload['description'] ?? '');
        $amount  = (float)($payload['amount'] ?? 0);
        $transId = $payload['transaction_id'] ?? '';

        $orderService   = new OrderService();
        $paymentService = new PaymentService();

        // 2. VietQR: Kiểm tra mã đơn hàng LS...
        if (!empty($content) && preg_match('/LS\d+/i', $content, $matches)) {
            $orderCode = strtoupper($matches[0]);
            
            if ($amount <= 0 && preg_match('/(?:\+|KH:\s*|TIEN:\s*|^)(\d+(?:\.\d+)?)/i', $content, $amtMatches)) {
                $amount = (float)$amtMatches[1];
            }

            $result = $orderService->processPaymentByOrderCode($orderCode, $amount, $transId ?: $orderCode);
            $this->json(['status' => $result['status'], 'message' => $result['message']], $result['status'] ? 200 : 400);
            return;
        }

        // 3. Tự động bóc tách số tiền từ nội dung thông báo WeChat (Ví dụ: 微信支付收款0.50元)
        if ($amount <= 0 && !empty($content)) {
            if (preg_match('/(\d+(?:\.\d+)?)/', $content, $amtMatches)) {
                $amount = (float)$amtMatches[1];
            }
        }

        if ($amount <= 0) {
            $this->json(['status' => false, 'message' => 'Không thể bóc tách số tiền hợp lệ.'], 400);
            return;
        }

        // 4. Khớp đơn tự động WeChat Pay theo số tiền
        $result = $orderService->processPaymentByAmount($amount, $transId);
        $this->json(['status' => $result['status'], 'message' => $result['message']], $result['status'] ? 200 : 404);
    }
}
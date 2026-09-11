<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\OrderService;
use App\Services\PaymentService;

class PaymentController extends BaseController
{
    public function webhook(): void
    {
        $rawInput = file_get_contents('php://input');
        $payload = json_decode($rawInput, true) ?: $_POST;

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

        $content = strtoupper(trim($payload['content'] ?? $payload['description'] ?? ''));
        $amount  = (float)($payload['amount'] ?? 0);
        $transId = $payload['transaction_id'] ?? '';

        $orderService   = new OrderService();
        $paymentService = new PaymentService();

        // 2. VietQR: Kiểm tra mã đơn hàng LS...
        if (!empty($content) && preg_match('/LS\d+/', $content, $matches)) {
            $orderCode = $matches[0];
            
            // Nếu chưa có amount truyền lên, tự bóc tách số tiền trong content
            if ($amount <= 0 && preg_match('/(?:\+|KH:\s*|TIEN:\s*|^)(\d+(?:\.\d+)?)/i', $content, $amtMatches)) {
                $amount = (float)$amtMatches[1];
            }

            $result = $orderService->processPaymentByOrderCode($orderCode, $amount, $transId ?: $orderCode);

            if ($result['status']) {
                $this->json(['status' => true, 'message' => $result['message']]);
            } else {
                $this->json(['status' => false, 'message' => $result['message']], 400);
            }
            return;
        }

        // 3. VietQR: Kiểm tra mã nạp tiền DEP...
        if (!empty($content) && preg_match('/DEP\d+/', $content, $matches)) {
            $transCode = $matches[0];
            $result = $paymentService->completePaymentByCode($transCode, $amount);

            if ($result) {
                $this->json(['status' => true, 'message' => 'Nạp tiền vào tài khoản thành công.']);
            } else {
                $this->json(['status' => false, 'message' => 'Xử lý mã nạp tiền thất bại hoặc đã được xử lý.'], 400);
            }
            return;
        }

        // 4. Nếu chưa có amount, tự động bóc tách số tiền từ nội dung thông báo (Ví dụ: 微信支付收款1.00元)
        if ($amount <= 0 && !empty($content)) {
            if (preg_match('/(\d+(?:\.\d+)?)/', $content, $amtMatches)) {
                $amount = (float)$amtMatches[1];
            }
        }

        if ($amount <= 0) {
            $this->json(['status' => false, 'message' => 'Không thể bóc tách số tiền hợp lệ từ nội dung thông báo.'], 400);
            return;
        }

        // 5. WeChat Pay: Khớp đơn tự động theo số tiền lẻ duy nhất
        $result = $orderService->processPaymentByAmount($amount, $transId);
        if ($result['status']) {
            $this->json(['status' => true, 'message' => $result['message']]);
            return;
        }

        $this->json(['status' => false, 'message' => $result['message']], 404);
    }
}
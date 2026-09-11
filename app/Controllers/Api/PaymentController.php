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

        // Kiểm tra Secret Token bảo mật
        $config = require __DIR__ . '/../../../config/app.php';
        $expectedSecret = $config['macrodroid_secret'] ?? '';
        $providedSecret = $payload['secret'] ?? $_SERVER['HTTP_X_MACRODROID_SECRET'] ?? '';

        if (empty($expectedSecret) || !hash_equals($expectedSecret, $providedSecret)) {
            $this->json(['status' => false, 'message' => 'Mã xác thực Webhook không hợp lệ.'], 403);
            return;
        }

        $content = strtoupper(trim($payload['content'] ?? $payload['description'] ?? ''));
        $amount  = (float)($payload['amount'] ?? 0);
        $transId = $payload['transaction_id'] ?? '';

        if ($amount <= 0) {
            $this->json(['status' => false, 'message' => 'Số tiền chuyển khoản không hợp lệ.'], 400);
            return;
        }

        $orderService   = new OrderService();
        $paymentService = new PaymentService();

        // 1. VietQR: Lọc mã đơn hàng (LS...) trong nội dung
        if (!empty($content) && preg_match('/LS\d+/', $content, $matches)) {
            $orderCode = $matches[0];
            $result = $orderService->processPaymentByOrderCode($orderCode, $amount, $transId ?: $orderCode);

            if ($result['status']) {
                $this->json(['status' => true, 'message' => $result['message']]);
            } else {
                $this->json(['status' => false, 'message' => $result['message']], 400);
            }
            return;
        }

        // 2. VietQR: Lọc mã nạp tiền (DEP...) trong nội dung
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

        // 3. WeChat Pay (Hoặc fallback): Khớp tự động dựa theo số tiền lẻ duy nhất
        $result = $orderService->processPaymentByAmount($amount, $transId);
        if ($result['status']) {
            $this->json(['status' => true, 'message' => $result['message']]);
            return;
        }

        $this->json(['status' => false, 'message' => $result['message']], 404);
    }
}
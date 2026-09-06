<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;

class PaymentService
{
    /**
     * Tạo giao dịch nạp tiền vào ví
     */
    public function createDepositTransaction(int $userId, float $amount, string $paymentMethod): array
    {
        if ($amount < 10000) {
            return ['status' => false, 'message' => 'Số tiền nạp tối thiểu là 10.000 VNĐ.'];
        }

        $transCode = 'DEP' . date('YmdHis') . rand(100, 999);

        $paymentData = [
            'transaction_code' => $transCode,
            'user_id' => $userId,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $paymentModel = new Payment();
        $created = $paymentModel->create($paymentData);

        if ($created) {
            return [
                'status' => true,
                'message' => 'Tạo giao dịch nạp tiền thành công.',
                'transaction_code' => $transCode,
                'amount' => $amount
            ];
        }

        return ['status' => false, 'message' => 'Không thể tạo giao dịch nạp tiền.'];
    }

    /**
     * Duyệt nạp tiền và cộng số dư tài khoản người dùng
     */
    public function completePayment(int $paymentId): bool
    {
        $paymentModel = new Payment();
        $payment = $paymentModel->find($paymentId);

        if (!$payment || $payment['status'] === 'completed') {
            return false;
        }

        // Cập nhật giao dịch nạp tiền thành công
        $paymentModel->update($paymentId, [
            'status' => 'completed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Cộng số dư vào tài khoản người dùng
        $userModel = new User();
        $user = $userModel->find($payment['user_id']);

        if ($user) {
            $newBalance = (float)($user['balance'] ?? 0) + (float)$payment['amount'];
            return $userModel->update($user['id'], [
                'balance' => $newBalance,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return false;
    }
}
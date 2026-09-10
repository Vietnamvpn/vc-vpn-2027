<?php

namespace App\Services;

use App\Models\Order;
use App\Models\VpnPlan;
use App\Models\Coupon;
use App\Models\Subscription;

class OrderService
{
    /**
     * Xử lý tạo đơn hàng mới
     */
    public function createOrder(int $userId, int $planId, ?string $couponCode = null): array
    {
        $planModel = new VpnPlan();
        $plan = $planModel->find($planId);

        if (!$plan || ($plan['status'] ?? 'active') !== 'active') {
            return ['status' => false, 'message' => 'Gói dịch vụ không tồn tại hoặc đã bị ẩn.'];
        }

        $originalPrice = (float)($plan['price'] ?? 0);
        $discountAmount = 0.0;

        if (!empty($couponCode)) {
            $couponModel = new Coupon();
            $coupon = method_exists($couponModel, 'findByCode') 
                ? $couponModel->findByCode($couponCode) 
                : null;

            if ($coupon && ($coupon['status'] ?? '') === 'active') {
                $isExpired = !empty($coupon['expires_at']) && strtotime($coupon['expires_at']) < time();
                $isMaxUsed = !empty($coupon['max_uses']) && ((int)($coupon['used_count'] ?? 0) >= (int)$coupon['max_uses']);

                if (!$isExpired && !$isMaxUsed) {
                    $discountType = $coupon['discount_type'] ?? 'percent';
                    $discountVal  = (float)($coupon['discount_value'] ?? 0);

                    if ($discountType === 'percent') {
                        $discountAmount = ($originalPrice * $discountVal) / 100;
                    } else {
                        $discountAmount = $discountVal;
                    }

                    if ($discountAmount > $originalPrice) {
                        $discountAmount = $originalPrice;
                    }
                }
            }
        }

        $finalPrice = max(0.0, $originalPrice - $discountAmount);
        $orderCode  = 'LS' . date('YmdHis') . rand(100, 999);

        $orderData = [
            'order_code'   => $orderCode,
            'user_id'      => $userId,
            'plan_id'      => $planId,
            'price'        => $originalPrice,
            'discount'     => $discountAmount,
            'final_amount' => $finalPrice,
            'status'       => 'pending',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $orderModel = new Order();
        $created = $orderModel->create($orderData);

        if ($created) {
            return [
                'status'     => true,
                'message'    => 'Tạo đơn hàng thành công.',
                'order_code' => $orderCode,
                'amount'     => $finalPrice
            ];
        }

        return ['status' => false, 'message' => 'Không thể khởi tạo đơn hàng. Vui lòng thử lại.'];
    }

    /**
     * Kích hoạt gói dịch vụ sau khi thanh toán thành công
     */
    public function activateOrder(int $orderId): bool
    {
        $orderModel = new Order();
        $order = $orderModel->find($orderId);

        if (!$order || $order['status'] === 'completed') {
            return false;
        }

        // Cập nhật trạng thái đơn hàng sang completed
        $orderModel->update($orderId, [
            'status' => 'completed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Tạo hoặc gia hạn gói đăng ký (Subscription) cho người dùng
        $subModel = new Subscription();
        $vpnService = new VpnService();

        $subData = [
            'user_id' => $order['user_id'],
            'plan_id' => $order['plan_id'],
            'uuid' => $vpnService->generateUuid(),
            'subscribe_token' => $vpnService->generateSubscribeToken(),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $subModel->create($subData);
    }
}
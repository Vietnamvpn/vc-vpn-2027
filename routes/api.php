<?php

return [
    // API cấp liên kết Đăng ký cho App Client (V2Ray, Clash, Sing-Box...)
    'GET /api/v1/client/subscribe'  => ['Api\ClientController', 'subscribe'],

    // API giao tiếp Máy chủ Node (Đồng bộ User & Báo cáo Traffic)
    'POST /api/v1/server/checkin'      => ['Api\ServerController', 'checkin'],
    'GET /api/v1/server/users'         => ['Api\ServerController', 'users'],
    'POST /api/v1/server/push-traffic' => ['Api\ServerController', 'pushTraffic'],

    // API Webhook xử lý thanh toán tự động
    'POST /api/v1/payment/webhook'     => ['Api\PaymentController', 'webhook'],
];
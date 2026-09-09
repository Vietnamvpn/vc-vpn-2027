<?php

return [
    // API cấp liên kết Đăng ký cho App Client (V2Ray, Clash, Sing-Box...)
    'GET /sub'                         => ['Api\ClientController', 'subscribe'],

    // API giao tiếp Máy chủ Node (Đồng bộ User & Báo cáo Traffic)
    'POST /api/server/checkin'      => ['Api\ServerController', 'checkin'],
    'GET /api/server/users'         => ['Api\ServerController', 'users'],
    'POST /api/server/push-traffic' => ['Api\ServerController', 'pushTraffic'],

    // API Webhook xử lý thanh toán tự động
    'POST /api/payment/webhook'     => ['Api\PaymentController', 'webhook'],
];
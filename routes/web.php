<?php

return [
    // Trang chủ & Công khai (Public)
    'GET /'                      => ['HomeController', 'index'],
    'GET /plans'                 => ['HomeController', 'plans'],
    'GET /faq'                   => ['HomeController', 'faq'],
    'GET /contact'               => ['HomeController', 'contact'],
    'POST /contact'              => ['HomeController', 'sendContact'],

    // Xác thực tài khoản (Auth)
    'GET /login'                 => ['AuthController', 'showLogin'],
    'POST /login'                => ['AuthController', 'login'],
    'GET /register'              => ['AuthController', 'showRegister'],
    'POST /register'             => ['AuthController', 'register'],
    'GET /forgot-password'       => ['AuthController', 'showForgotPassword'],
    'POST /forgot-password'      => ['AuthController', 'sendResetLink'],
    'GET /reset-password'        => ['AuthController', 'showResetPassword'],
    'POST /reset-password'       => ['AuthController', 'resetPassword'],
    'GET /logout'                => ['AuthController', 'logout'],

    // Khách hàng (User Dashboard)
    'GET /dashboard'             => ['UserController', 'dashboard'],
    
    // Hồ sơ cá nhân (Profile)
    'GET /profile'               => ['UserController', 'profile'],
    'POST /profile/update'       => ['UserController', 'updateProfile'],
    'GET /profile/password'      => ['UserController', 'showChangePassword'],
    'POST /profile/password'     => ['UserController', 'changePassword'],

    // Gói cước & Mua hàng (Plans & Checkout)
    'GET /user/plans'            => ['UserController', 'plans'],
    'GET /checkout'              => ['UserController', 'checkout'],
    'POST /checkout'             => ['UserController', 'buyPlan'],

    // Gói dịch vụ đã mua & Kết nối VPN (Subscriptions)
    'GET /subscriptions'         => ['UserController', 'subscriptions'],
    'GET /subscriptions/detail'  => ['UserController', 'subscriptionDetail'],
    'GET /subscriptions/connect' => ['UserController', 'subscriptionConnect'],

    // Đơn hàng (Orders)
    'GET /orders'                => ['UserController', 'orders'],
    'GET /orders/detail'         => ['UserController', 'orderDetail'],

    // Lịch sử thanh toán & Nạp tiền (Payments)
    'GET /payments'              => ['UserController', 'payments'],
    'GET /payments/deposit'      => ['UserController', 'showDeposit'],
    'POST /payments/deposit'     => ['UserController', 'deposit'],

    // Ví tiền (Wallet)
    'GET /wallet'                => ['UserController', 'wallet'],
    'POST /wallet/deposit'       => ['UserController', 'walletDeposit'],

    // Tiếp thị liên kết (Referrals)
    'GET /referrals'             => ['UserController', 'referrals'],

    // Yêu cầu rút tiền (Withdrawals)
    'GET /withdrawals'           => ['UserController', 'withdrawals'],
    'GET /withdrawals/create'    => ['UserController', 'showCreateWithdrawal'],
    'POST /withdrawals/create'   => ['UserController', 'createWithdrawal'],

    // Hỗ trợ kỹ thuật (Tickets)
    'GET /tickets'               => ['UserController', 'tickets'],
    'GET /tickets/create'        => ['UserController', 'showCreateTicket'],
    'POST /tickets/create'       => ['UserController', 'createTicket'],
    'GET /tickets/detail'        => ['UserController', 'ticketDetail'],
    'POST /tickets/reply'        => ['UserController', 'replyTicket'],

    // Thông báo (Notifications)
    'GET /notifications'         => ['UserController', 'notifications'],

    // Quản trị viên (Admin Panel)
    'GET /admin'                 => ['Admin\DashboardController', 'index'],
    
    // Quản lý người dùng (Users)
    'GET /admin/users'           => ['Admin\UserController', 'index'],
    'GET /admin/users/create'    => ['Admin\UserController', 'create'],
    'POST /admin/users/create'   => ['Admin\UserController', 'create'],
    'GET /admin/users/edit'      => ['Admin\UserController', 'edit'],
    'POST /admin/users/edit'     => ['Admin\UserController', 'edit'],
    'GET /admin/users/detail'    => ['Admin\UserController', 'detail'],
    'GET /admin/users/delete'    => ['Admin\UserController', 'delete'],

    // Quản lý nhóm máy chủ (Server Groups)
    'GET /admin/server-groups'          => ['Admin\ServerGroupController', 'index'],
    'GET /admin/server-groups/create'   => ['Admin\ServerGroupController', 'showCreate'],
    'POST /admin/server-groups/create'  => ['Admin\ServerGroupController', 'create'],
    'GET /admin/server-groups/edit'     => ['Admin\ServerGroupController', 'showEdit'],
    'POST /admin/server-groups/edit'    => ['Admin\ServerGroupController', 'edit'],
    'GET /admin/server-groups/delete'  => ['Admin\ServerGroupController', 'delete'],

    // Quản lý máy chủ (Servers)
    'GET /admin/servers'          => ['Admin\ServerController', 'index'],
    'GET /admin/servers/create'   => ['Admin\ServerController', 'showCreate'],
    'POST /admin/servers/create'  => ['Admin\ServerController', 'create'],
    'GET /admin/servers/edit'     => ['Admin\ServerController', 'showEdit'],
    'POST /admin/servers/edit'    => ['Admin\ServerController', 'edit'],
    'GET /admin/servers/detail'   => ['Admin\ServerController', 'detail'],
    'GET /admin/servers/delete'   => ['Admin\ServerController', 'delete'],

    // Quản lý nút kết nối (Nodes)
    'GET /admin/nodes'            => ['Admin\NodeController', 'index'],
    'GET /admin/nodes/detail'     => ['Admin\NodeController', 'detail'],
    'GET /admin/nodes/delete'     => ['Admin\NodeController', 'delete'],

    // Quản lý gói cước (Plans)
    'GET /admin/plans'            => ['Admin\PlanController', 'index'],
    'GET /admin/plans/create'     => ['Admin\PlanController', 'showCreate'],
    'POST /admin/plans/create'    => ['Admin\PlanController', 'create'],
    'GET /admin/plans/edit'       => ['Admin\PlanController', 'showEdit'],
    'POST /admin/plans/edit'      => ['Admin\PlanController', 'edit'],
    'GET /admin/plans/delete'     => ['Admin\PlanController', 'delete'],

    // Quản lý mã giảm giá (Coupons)
    'GET /admin/coupons'          => ['Admin\CouponController', 'index'],
    'GET /admin/coupons/create'   => ['Admin\CouponController', 'showCreate'],
    'POST /admin/coupons/create'  => ['Admin\CouponController', 'create'],
    'GET /admin/coupons/edit'     => ['Admin\CouponController', 'showEdit'],
    'POST /admin/coupons/edit'    => ['Admin\CouponController', 'edit'],
    'GET /admin/coupons/delete'   => ['Admin\CouponController', 'delete'],

    // Quản lý đơn hàng (Orders)
    'GET /admin/orders'               => ['Admin\OrderController', 'index'],
    'GET /admin/orders/create'        => ['Admin\OrderController', 'create'],
    'POST /admin/orders/create'       => ['Admin\OrderController', 'create'],
    'GET /admin/orders/detail'        => ['Admin\OrderController', 'detail'],
    'GET /admin/orders/update-status' => ['Admin\OrderController', 'updateStatus'],
    'GET /admin/orders/delete'        => ['Admin\OrderController', 'delete'],

    // Quản lý thanh toán (Payments)
    'GET /admin/payments'         => ['Admin\PaymentController', 'index'],
    'GET /admin/payments/detail'  => ['Admin\PaymentController', 'detail'],

    // Quản lý gói đăng ký (Subscriptions)
    'GET /admin/subscriptions'               => ['Admin\SubscriptionController', 'index'],
    'GET /admin/subscriptions/detail'        => ['Admin\SubscriptionController', 'detail'],
    'GET /admin/subscriptions/update-status' => ['Admin\SubscriptionController', 'updateStatus'],
    'GET /admin/subscriptions/renew'         => ['Admin\SubscriptionController', 'renew'],
    'GET /admin/subscriptions/reset-traffic'  => ['Admin\SubscriptionController', 'resetTraffic'],
    'GET /admin/subscriptions/delete'        => ['Admin\SubscriptionController', 'delete'],
    
    // Quản lý hoa hồng & giới thiệu (Referrals)
    'GET /admin/referrals'        => ['Admin\ReferralController', 'index'],

    // Quản lý yêu cầu rút tiền (Withdrawals)
    'GET /admin/withdrawals'        => ['Admin\WithdrawalController', 'index'],
    'GET /admin/withdrawals/detail' => ['Admin\WithdrawalController', 'detail'],

    // Quản lý bài viết & tin tức (Posts)
    'GET /admin/posts'            => ['Admin\PostController', 'index'],
    'GET /admin/posts/create'     => ['Admin\PostController', 'showCreate'],
    'POST /admin/posts/create'    => ['Admin\PostController', 'create'],
    'GET /admin/posts/edit'       => ['Admin\PostController', 'showEdit'],
    'POST /admin/posts/edit'      => ['Admin\PostController', 'edit'],
    'GET /admin/posts/detail'     => ['Admin\PostController', 'detail'],
    'GET /admin/posts/delete'     => ['Admin\PostController', 'delete'],

    // Quản lý hỗ trợ (Tickets)
    'GET /admin/tickets'          => ['Admin\TicketController', 'index'],
    'GET /admin/tickets/detail'   => ['Admin\TicketController', 'detail'],

    // Quản lý chi phí (Expenses)
    'GET /admin/expenses'         => ['Admin\ExpenseController', 'index'],
    'GET /admin/expenses/create'  => ['Admin\ExpenseController', 'showCreate'],
    'POST /admin/expenses/create' => ['Admin\ExpenseController', 'create'],
    'GET /admin/expenses/edit'    => ['Admin\ExpenseController', 'showEdit'],
    'POST /admin/expenses/edit'   => ['Admin\ExpenseController', 'edit'],
    'GET /admin/expenses/delete'  => ['Admin\ExpenseController', 'delete'],

    // Cài đặt hệ thống (Settings)
    'GET /admin/settings'         => ['Admin\SettingController', 'index'],
    'POST /admin/settings/save'   => ['Admin\SettingController', 'save'],

    // Nhật ký hệ thống (Logs)
    'GET /admin/logs/system'      => ['Admin\LogController', 'system'],
    'GET /admin/logs/access'      => ['Admin\LogController', 'access'],
    'GET /admin/logs/email'       => ['Admin\LogController', 'email'],
];
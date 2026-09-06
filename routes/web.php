<?php

return [
    // Trang chủ & Công khai
    'GET /'                      => ['HomeController', 'index'],
    'GET /plans'                 => ['HomeController', 'plans'],
    'GET /faq'                   => ['HomeController', 'faq'],
    'GET /contact'               => ['HomeController', 'contact'],
    'POST /contact'              => ['HomeController', 'sendContact'],

    // Xác thực tài khoản
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
    'GET /user/plans'            => ['UserController', 'plans'],
    'GET /checkout'              => ['UserController', 'checkout'],
    'POST /checkout'             => ['UserController', 'buyPlan'],
    'GET /subscriptions'         => ['UserController', 'subscriptions'],
    'GET /orders'                => ['UserController', 'orders'],
    'GET /payments'              => ['UserController', 'payments'],
    'GET /wallet'                => ['UserController', 'wallet'],
    'POST /wallet/deposit'       => ['UserController', 'deposit'],
    'GET /referrals'             => ['UserController', 'referrals'],
    'GET /tickets'               => ['UserController', 'tickets'],
    'POST /tickets/create'       => ['UserController', 'createTicket'],
    'GET /profile'               => ['UserController', 'profile'],
    'POST /profile/update'       => ['UserController', 'updateProfile'],

    // Quản trị viên (Admin Panel)
    'GET /admin'                 => ['Admin\DashboardController', 'index'],
    'GET /admin/users'           => ['Admin\UserController', 'index'],
    'GET /admin/server-groups'   => ['Admin\ServerGroupController', 'index'],
    'GET /admin/servers'         => ['Admin\ServerController', 'index'],
    'GET /admin/nodes'           => ['Admin\NodeController', 'index'],
    'GET /admin/plans'           => ['Admin\PlanController', 'index'],
    'GET /admin/coupons'         => ['Admin\CouponController', 'index'],
    'GET /admin/orders'          => ['Admin\OrderController', 'index'],
    'GET /admin/payments'        => ['Admin\PaymentController', 'index'],
    'GET /admin/subscriptions'   => ['Admin\SubscriptionController', 'index'],
    'GET /admin/referrals'       => ['Admin\ReferralController', 'index'],
    'GET /admin/withdrawals'     => ['Admin\WithdrawalController', 'index'],
    'GET /admin/posts'           => ['Admin\PostController', 'index'],
    'GET /admin/tickets'         => ['Admin\TicketController', 'index'],
    'GET /admin/expenses'        => ['Admin\ExpenseController', 'index'],
    'GET /admin/settings'        => ['Admin\SettingController', 'index'],
    'POST /admin/settings/save'  => ['Admin\SettingController', 'save'],
    'GET /admin/logs/system'     => ['Admin\LogController', 'system'],
];
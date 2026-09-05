<?php

return [
    // Trang chủ & Công khai
    'GET /'                      => ['HomeController', 'index'],
    'GET /home/plans'            => ['HomeController', 'plans'],
    'GET /home/faq'              => ['HomeController', 'faq'],
    'GET /home/contact'          => ['HomeController', 'contact'],
    'POST /home/contact'         => ['HomeController', 'sendContact'],

    // Xác thực tài khoản
    'GET /auth/login'            => ['AuthController', 'showLogin'],
    'POST /auth/login'           => ['AuthController', 'login'],
    'GET /auth/register'         => ['AuthController', 'showRegister'],
    'POST /auth/register'        => ['AuthController', 'register'],
    'GET /auth/forgot-password'  => ['AuthController', 'showForgotPassword'],
    'POST /auth/forgot-password' => ['AuthController', 'sendResetLink'],
    'GET /auth/reset-password'   => ['AuthController', 'showResetPassword'],
    'POST /auth/reset-password'  => ['AuthController', 'resetPassword'],
    'GET /logout'                => ['AuthController', 'logout'],

    // Khách hàng (User Dashboard)
    'GET /user/dashboard'        => ['UserController', 'dashboard'],
    'GET /user/plans'            => ['UserController', 'plans'],
    'GET /user/plans/checkout'   => ['UserController', 'checkout'],
    'POST /user/plans/buy'       => ['UserController', 'buyPlan'],
    'GET /user/subscriptions'    => ['UserController', 'subscriptions'],
    'GET /user/orders'           => ['UserController', 'orders'],
    'GET /user/payments'         => ['UserController', 'payments'],
    'GET /user/wallet'           => ['UserController', 'wallet'],
    'POST /user/wallet/deposit'  => ['UserController', 'deposit'],
    'GET /user/referrals'        => ['UserController', 'referrals'],
    'GET /user/tickets'          => ['UserController', 'tickets'],
    'POST /user/tickets/create'  => ['UserController', 'createTicket'],
    'GET /user/profile'          => ['UserController', 'profile'],
    'POST /user/profile/update'  => ['UserController', 'updateProfile'],

    // Quản trị viên (Admin Panel)
    'GET /admin/dashboard'       => ['Admin\DashboardController', 'index'],
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
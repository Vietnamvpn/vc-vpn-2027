* ##cấu trúc dự án:
```
vc-vpn-2027/
├── vc_install.sh
├── vc_update.sh
├── .env.example
├── composer.json
├── README.md
│
├── public/
│   ├── index.php
│   ├── favicon.ico
│   └── assets/
│       ├── css/
│       │   ├── app.css
│       │   ├── admin.css
│       │   └── auth.css
│       │
│       ├── js/
│       │   ├── app.js
│       │   ├── admin.js
│       │   └── auth.js
│       │
│       └── images/
│           ├── logo.png
│           └── favicon.png
│
├── config/
│   ├── app.php
│   └── database.php
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── ServerController.php
│   │   ├── NodeController.php
│   │   ├── PlanController.php
│   │   ├── CouponController.php
│   │   ├── OrderController.php
│   │   ├── PaymentController.php
│   │   ├── SubscriptionController.php
│   │   ├── ReferralController.php
│   │   ├── WithdrawalController.php
│   │   ├── PostController.php
│   │   ├── TicketController.php
│   │   ├── SettingController.php
│   │   └── LogController.php
│   │
│   ├── Models/
│   │   ├── Setting.php
│   │   ├── User.php
│   │   ├── AccessLog.php
│   │   ├── ServerGroup.php
│   │   ├── Server.php
│   │   ├── NodeInbound.php
│   │   ├── NodeTask.php
│   │   ├── VpnPlan.php
│   │   ├── Coupon.php
│   │   ├── Order.php
│   │   ├── Payment.php
│   │   ├── Subscription.php
│   │   ├── ReferralCommission.php
│   │   ├── Withdrawal.php
│   │   ├── Post.php
│   │   ├── SupportTicket.php
│   │   ├── TicketMessage.php
│   │   ├── SystemLog.php
│   │   ├── EmailLog.php
│   │   └── Expense.php
│   │
│   └── Services/
│       ├── VpnService.php
│       ├── OrderService.php
│       ├── PaymentService.php
│       └── ServerService.php
│
├── resources/
│   └── views/
│       │
│       ├── layouts/
│       │   ├── app.php
│       │   ├── admin.php
│       │   ├── auth.php
│       │   ├── header.php
│       │   ├── navbar.php
│       │   ├── sidebar.php
│       │   ├── admin-sidebar.php
│       │   └── footer.php
│       │
│       ├── components/
│       │   ├── alert.php
│       │   ├── modal.php
│       │   ├── pagination.php
│       │   ├── status-badge.php
│       │   ├── plan-card.php
│       │   ├── server-status.php
│       │   └── subscription-card.php
│       │
│       ├── auth/
│       │   ├── login.php
│       │   ├── register.php
│       │   ├── forgot-password.php
│       │   └── reset-password.php
│       │
│       ├── home/
│       │   ├── index.php
│       │   ├── plans.php
│       │   ├── faq.php
│       │   └── contact.php
│       │
│       ├── user/
│       │   ├── dashboard.php
│       │   │
│       │   ├── profile/
│       │   │   ├── index.php
│       │   │   └── password.php
│       │   │
│       │   ├── plans/
│       │   │   ├── index.php
│       │   │   └── checkout.php
│       │   │
│       │   ├── orders/
│       │   │   ├── index.php
│       │   │   └── detail.php
│       │   │
│       │   ├── subscriptions/
│       │   │   ├── index.php
│       │   │   ├── detail.php
│       │   │   └── connect.php
│       │   │
│       │   ├── payments/
│       │   │   ├── index.php
│       │   │   └── deposit.php
│       │   │
│       │   ├── wallet/
│       │   │   └── index.php
│       │   │
│       │   ├── referrals/
│       │   │   └── index.php
│       │   │
│       │   ├── withdrawals/
│       │   │   ├── index.php
│       │   │   └── create.php
│       │   │
│       │   ├── tickets/
│       │   │   ├── index.php
│       │   │   ├── create.php
│       │   │   └── detail.php
│       │   │
│       │   └── notifications/
│       │       └── index.php
│       │
│       └── admin/
│           ├── dashboard.php
│           │
│           ├── users/
│           │   ├── index.php
│           │   ├── create.php
│           │   ├── edit.php
│           │   └── detail.php
│           │
│           ├── server-groups/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           │
│           ├── servers/
│           │   ├── index.php
│           │   ├── create.php
│           │   ├── edit.php
│           │   └── detail.php
│           │
│           ├── nodes/
│           │   ├── index.php
│           │   ├── create.php
│           │   ├── edit.php
│           │   └── detail.php
│           │
│           ├── plans/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           │
│           ├── coupons/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           │
│           ├── orders/
│           │   ├── index.php
│           │   └── detail.php
│           │
│           ├── payments/
│           │   ├── index.php
│           │   └── detail.php
│           │
│           ├── subscriptions/
│           │   ├── index.php
│           │   └── detail.php
│           │
│           ├── referrals/
│           │   └── index.php
│           │
│           ├── withdrawals/
│           │   ├── index.php
│           │   └── detail.php
│           │
│           ├── posts/
│           │   ├── index.php
│           │   ├── create.php
│           │   ├── edit.php
│           │   └── detail.php
│           │
│           ├── tickets/
│           │   ├── index.php
│           │   └── detail.php
│           │
│           ├── expenses/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           │
│           ├── settings/
│           │   └── index.php
│           │
│           └── logs/
│               ├── system.php
│               ├── access.php
│               └── email.php
│
├── database/
│   └── vpn_service.sql
│
└── storage/
    └── logs/
        └── .gitkeep
```
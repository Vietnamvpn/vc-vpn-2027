<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Subscription;

class SubscriptionController extends BaseController
{
    private Subscription $subscriptionModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->subscriptionModel = new Subscription();
    }

    public function index(): void
    {
        $subscriptions = $this->subscriptionModel->allWithDetails();

        $this->render('admin.subscriptions.index', [
            'activeMenu'    => 'subscriptions',
            'subscriptions' => $subscriptions
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $subscription = $this->subscriptionModel->findWithDetails($id);

        if (!$subscription) {
            $_SESSION['error'] = 'Gói đăng ký không tồn tại!';
            $this->redirect('/admin/subscriptions');
            return;
        }

        $this->render('admin.subscriptions.detail', [
            'activeMenu'   => 'subscriptions',
            'subscription' => $subscription
        ]);
    }
}
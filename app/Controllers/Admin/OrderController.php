<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Order;

class OrderController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->orderModel = new Order();
    }

    public function index(): void
    {
        $orders = $this->orderModel->allWithDetails();

        $this->render('admin.orders.index', [
            'activeMenu' => 'orders',
            'orders'     => $orders
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->orderModel->findWithDetails($id);

        if (!$order) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại!';
            $this->redirect('/admin/orders');
            return;
        }

        $this->render('admin.orders.detail', [
            'activeMenu' => 'orders',
            'order'      => $order
        ]);
    }
}
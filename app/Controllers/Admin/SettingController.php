<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SettingController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function index(): void
    {
        $this->render('admin.settings.index', [
            'activeMenu' => 'settings'
        ]);
    }

    public function save(): void
    {
        $_SESSION['success'] = 'Cập nhật cấu hình hệ thống thành công.';
        $this->redirect('/admin/settings');
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class LogController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function system(): void
    {
        $this->render('admin.logs.system', [
            'activeMenu' => 'logs'
        ]);
    }
}
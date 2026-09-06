<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function index(): void
    {
        $users = [];
        if (class_exists('App\Models\User')) {
            $userModel = new User();
            $users = method_exists($userModel, 'getAll') ? $userModel->getAll() : [];
        }

        $this->render('admin.users.index', [
            'users' => $users,
            'activeMenu' => 'users'
        ]);
    }
}
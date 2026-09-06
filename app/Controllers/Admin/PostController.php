<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PostController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function index(): void
    {
        $this->render('admin.posts.index', [
            'activeMenu' => 'posts'
        ]);
    }
}
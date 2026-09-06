<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class NodeController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function index(): void
    {
        $this->render('admin.nodes.index', [
            'activeMenu' => 'nodes'
        ]);
    }
}
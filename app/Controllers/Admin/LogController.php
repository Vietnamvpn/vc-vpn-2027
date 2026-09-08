<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SystemLog;
use App\Models\AccessLog;
use App\Models\EmailLog;

class LogController extends BaseController
{
    private SystemLog $systemLogModel;
    private AccessLog $accessLogModel;
    private EmailLog $emailLogModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->systemLogModel = new SystemLog();
        $this->accessLogModel = new AccessLog();
        $this->emailLogModel = new EmailLog();
    }

    public function system(): void
    {
        $logs = $this->systemLogModel->allWithUser();

        $this->render('admin.logs.system', [
            'activeMenu' => 'logs',
            'logs'       => $logs
        ]);
    }

    public function access(): void
    {
        $logs = $this->accessLogModel->allWithUser();

        $this->render('admin.logs.access', [
            'activeMenu' => 'logs',
            'logs'       => $logs
        ]);
    }

    public function email(): void
    {
        $logs = $this->emailLogModel->all();

        $this->render('admin.logs.email', [
            'activeMenu' => 'logs',
            'logs'       => $logs
        ]);
    }
}
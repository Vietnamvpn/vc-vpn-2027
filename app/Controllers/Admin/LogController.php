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
            $this->redirect('/login');
        }
        $this->systemLogModel = new SystemLog();
        $this->accessLogModel = new AccessLog();
        $this->emailLogModel = new EmailLog();
    }

    public function index(): void
    {
        $this->system();
    }

    public function system(): void
    {
        $this->renderLogTab('system', [
            'logs' => $this->systemLogModel->allWithUser()
        ]);
    }

    public function access(): void
    {
        $this->renderLogTab('access', [
            'logs' => $this->accessLogModel->allWithUser()
        ]);
    }

    public function email(): void
    {
        $this->renderLogTab('email', [
            'logs' => $this->emailLogModel->all()
        ]);
    }

    /**
     * Hiển thị nhật ký MacroDroid Webhook
     */
    public function macrodroid(): void
    {
        $logFile = __DIR__ . '/../../../storage/logs/macrodroid_debug.log';
        $logContent = '';

        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
        }

        $this->renderLogTab('macrodroid', [
            'logContent' => $logContent
        ]);
    }

    /**
     * Xóa sạch file nhật ký MacroDroid
     */
    public function clearMacrodroid(): void
    {
        $logFile = __DIR__ . '/../../../storage/logs/macrodroid_debug.log';
        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
            $_SESSION['flash_message'] = 'Đã xóa sạch nội dung nhật ký MacroDroid!';
            $_SESSION['flash_type']    = 'success';
        }
        $this->redirect('/admin/logs/macrodroid');
    }

    private function renderLogTab(string $activeLogTab, array $data = []): void
    {
        $this->render('admin.logs.index', array_merge([
            'activeMenu'  => 'logs',
            'activeLogTab' => $activeLogTab,
            'logs'         => [],
            'logContent'   => ''
        ], $data));
    }
}

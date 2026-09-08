<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Setting;

class SettingController extends BaseController
{
    private Setting $settingModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->settingModel = new Setting();
    }

    public function index(): void
    {
        $settings = $this->settingModel->getAllAsKeyValue();

        $this->render('admin.settings.index', [
            'activeMenu' => 'settings',
            'settings'   => $settings
        ]);
    }

    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingsData = $_POST['settings'] ?? [];

            foreach ($settingsData as $key => $value) {
                $this->settingModel->setByKey($key, is_string($value) ? trim($value) : $value);
            }

            $_SESSION['flash_message'] = 'Cập nhật cấu hình hệ thống thành công!';
            $_SESSION['flash_type']    = 'success';
        }

        $this->redirect('/admin/settings');
    }
}
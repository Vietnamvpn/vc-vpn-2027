<?php

namespace App\Controllers;

use App\Models\VpnPlan;

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->render('home.index', [
            'activeMenu' => 'home'
        ]);
    }

    public function plans(): void
    {
        // Có thể lấy danh sách gói cước từ Model
        $plans = []; 
        if (class_exists('App\Models\VpnPlan')) {
            $planModel = new VpnPlan();
            $plans = $planModel->getAllActive();
        }

        $this->render('home.plans', [
            'activeMenu' => 'plans',
            'plans' => $plans
        ]);
    }

    public function faq(): void
    {
        $this->render('home.faq', [
            'activeMenu' => 'faq'
        ]);
    }

    public function contact(): void
    {
        $this->render('home.contact', [
            'activeMenu' => 'contact'
        ]);
    }

    public function sendContact(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
            $this->redirect('/home/contact');
        }

        // Xử lý lưu log hoặc gửi mail tại đây...
        
        $_SESSION['success'] = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.';
        $this->redirect('/home/contact');
    }
}
<?php

namespace App\Controllers;

use App\Models\VpnPlan;
use App\Models\Post;

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
        $posts = [];
        if (class_exists('App\Models\Post')) {
            $postModel = new Post();
            // Lấy danh sách bài viết/hướng dẫn từ cơ sở dữ liệu
            $posts = $postModel->getAllPublished(); 
        }

        $this->render('home.faq', [
            'activeMenu' => 'faq',
            'posts' => $posts
        ]);
    }

    public function postDetail(): void
    {
        $slug = $_GET['slug'] ?? '';
        $post = null;

        if (!empty($slug) && class_exists('App\Models\Post')) {
            $postModel = new Post();
            $post = $postModel->getBySlug($slug);
        }

        $this->render('home.post-detail', [
            'activeMenu' => 'faq',
            'post' => $post
        ]);
    }

}

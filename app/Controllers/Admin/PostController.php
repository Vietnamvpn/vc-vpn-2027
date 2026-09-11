<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Post;

class PostController extends BaseController
{
    private Post $postModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/login');
        }
        $this->postModel = new Post();
    }

    public function index(): void
    {
        $posts = $this->postModel->allWithAuthor();

        $this->render('admin.posts.index', [
            'activeMenu' => 'posts',
            'posts'      => $posts
        ]);
    }

    // GET /admin/posts/create
    public function showCreate(): void
    {
        $this->render('admin.posts.create', [
            'activeMenu' => 'posts'
        ]);
    }

    // POST /admin/posts/create
    public function create(): void
    {
        $title   = trim($_POST['title'] ?? '');
        $slug    = trim($_POST['slug'] ?? '');
        $type    = $_POST['type'] ?? 'news';
        $status  = $_POST['status'] ?? 'published';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ tiêu đề và nội dung bài viết!';
            $this->redirect('/admin/posts/create');
            return;
        }

        if (empty($slug)) {
            $slug = $this->createSlug($title);
        }

        $data = [
            'author_id'  => $_SESSION['user_id'],
            'title'      => $title,
            'slug'       => $slug,
            'content'    => $content,
            'type'       => $type,
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->postModel->create($data)) {
            $_SESSION['flash_message'] = 'Tạo bài viết mới thành công!';
            $_SESSION['flash_type']    = 'success';
            $this->redirect('/admin/posts');
        } else {
            $_SESSION['error'] = 'Lỗi hệ thống, không thể tạo bài viết!';
            $this->redirect('/admin/posts/create');
        }
    }

    // GET /admin/posts/edit
    public function showEdit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $post = $this->postModel->findWithAuthor($id);

        if (!$post) {
            $_SESSION['error'] = 'Bài viết không tồn tại!';
            $this->redirect('/admin/posts');
            return;
        }

        $this->render('admin.posts.edit', [
            'activeMenu' => 'posts',
            'post'       => $post
        ]);
    }

    // POST /admin/posts/edit
    public function edit(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        $post = $this->postModel->findWithAuthor($id);

        if (!$post) {
            $_SESSION['error'] = 'Bài viết không tồn tại!';
            $this->redirect('/admin/posts');
            return;
        }

        $title   = trim($_POST['title'] ?? '');
        $slug    = trim($_POST['slug'] ?? '');
        $type    = $_POST['type'] ?? 'news';
        $status  = $_POST['status'] ?? 'published';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ tiêu đề và nội dung bài viết!';
            $this->redirect('/admin/posts/edit?id=' . $id);
            return;
        }

        if (empty($slug)) {
            $slug = $this->createSlug($title);
        }

        $data = [
            'title'   => $title,
            'slug'    => $slug,
            'content' => $content,
            'type'    => $type,
            'status'  => $status
        ];

        if ($this->postModel->update($id, $data)) {
            $_SESSION['flash_message'] = 'Cập nhật bài viết thành công!';
            $_SESSION['flash_type']    = 'success';
            $this->redirect('/admin/posts');
        } else {
            $_SESSION['error'] = 'Không thể cập nhật thông tin bài viết!';
            $this->redirect('/admin/posts/edit?id=' . $id);
        }
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $post = $this->postModel->findWithAuthor($id);

        if (!$post) {
            $_SESSION['error'] = 'Bài viết không tồn tại!';
            $this->redirect('/admin/posts');
            return;
        }

        $this->render('admin.posts.detail', [
            'activeMenu' => 'posts',
            'post'       => $post
        ]);
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);

        if ($id > 0) {
            if ($this->postModel->delete($id)) {
                $_SESSION['flash_message'] = 'Đã xóa bài viết thành công!';
                $_SESSION['flash_type']    = 'success';
            } else {
                $_SESSION['error'] = 'Không thể xóa bài viết này!';
            }
        } else {
            $_SESSION['error'] = 'Mã bài viết không hợp lệ!';
        }

        $this->redirect('/admin/posts');
    }

    private function createSlug(string $string): string
    {
        $search = [
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ',
            'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
            'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
            'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
            'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
            'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
            'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
            'Đ'
        ];
        $replace = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd'
        ];
        $string = str_replace($search, $replace, $string);
        $string = preg_replace('/[^a-zA-Z0-9\s-]/', '', strtolower($string));
        $string = preg_replace('/[\s-]+/', '-', trim($string));
        return $string;
    }
}
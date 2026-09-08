<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NodeInbound;
use App\Models\Server;

class NodeController extends BaseController
{
    private NodeInbound $nodeModel;
    private Server $serverModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/login');
        }
        $this->nodeModel = new NodeInbound();
        $this->serverModel = new Server();
    }

    public function index(): void
    {
        $nodes = method_exists($this->nodeModel, 'getAllWithServer') 
            ? $this->nodeModel->getAllWithServer() 
            : $this->nodeModel->getAll();

        // Nếu model chưa có join server, tự ghép thông tin tên máy chủ
        if (!method_exists($this->nodeModel, 'getAllWithServer') && !empty($nodes)) {
            $servers = $this->serverModel->getAll();
            $serverMap = array_column($servers, null, 'id');
            foreach ($nodes as &$node) {
                $node['server_name'] = $serverMap[$node['server_id']]['name'] ?? 'Server #' . $node['server_id'];
                $node['server_ip'] = $serverMap[$node['server_id']]['ip_address'] ?? '';
            }
        }

        $this->render('admin.nodes.index', [
            'activeMenu' => 'nodes',
            'nodes'      => $nodes
        ]);
    }

    public function showCreate(): void
    {
        $servers = $this->serverModel->getAll();
        $this->render('admin.nodes.create', [
            'activeMenu' => 'nodes',
            'servers'    => $servers
        ]);
    }

    public function create(): void
    {
        $serverId = (int)($_POST['server_id'] ?? 0);
        $port     = (int)($_POST['port'] ?? 0);
        $protocol = trim($_POST['protocol'] ?? 'vless');
        $network  = trim($_POST['network'] ?? 'tcp');
        $tls      = (int)($_POST['tls'] ?? 1);
        $sni      = trim($_POST['sni'] ?? '');
        $host     = trim($_POST['host'] ?? '');
        $path     = trim($_POST['path'] ?? '');
        $status   = trim($_POST['status'] ?? 'active');

        if (!$serverId || !$port) {
            $_SESSION['error'] = 'Vui lòng chọn máy chủ và nhập cổng kết nối hợp lệ!';
            $this->redirect('/admin/nodes/create');
            return;
        }

        $this->nodeModel->create([
            'server_id' => $serverId,
            'port'      => $port,
            'protocol'  => $protocol,
            'network'   => $network,
            'tls'       => $tls,
            'sni'       => $sni ?: null,
            'host'      => $host ?: null,
            'path'      => $path ?: null,
            'status'    => $status
        ]);

        $_SESSION['flash_message'] = 'Tạo nút kết nối mới thành công!';
        $this->redirect('/admin/nodes');
    }

    public function showEdit(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $node = $id ? $this->nodeModel->find($id) : null;

        if (!$node) {
            $_SESSION['error'] = 'Nút kết nối không tồn tại!';
            $this->redirect('/admin/nodes');
            return;
        }

        $servers = $this->serverModel->getAll();
        $this->render('admin.nodes.edit', [
            'activeMenu' => 'nodes',
            'node'       => $node,
            'servers'    => $servers
        ]);
    }

    public function edit(): void
    {
        $id       = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $serverId = (int)($_POST['server_id'] ?? 0);
        $port     = (int)($_POST['port'] ?? 0);
        $protocol = trim($_POST['protocol'] ?? 'vless');
        $network  = trim($_POST['network'] ?? 'tcp');
        $tls      = (int)($_POST['tls'] ?? 1);
        $sni      = trim($_POST['sni'] ?? '');
        $host     = trim($_POST['host'] ?? '');
        $path     = trim($_POST['path'] ?? '');
        $status   = trim($_POST['status'] ?? 'active');

        if (!$id || !$serverId || !$port) {
            $_SESSION['error'] = 'Dữ liệu không hợp lệ!';
            $this->redirect('/admin/nodes/edit?id=' . $id);
            return;
        }

        $this->nodeModel->update($id, [
            'server_id' => $serverId,
            'port'      => $port,
            'protocol'  => $protocol,
            'network'   => $network,
            'tls'       => $tls,
            'sni'       => $sni ?: null,
            'host'      => $host ?: null,
            'path'      => $path ?: null,
            'status'    => $status
        ]);

        $_SESSION['flash_message'] = 'Cập nhật nút kết nối thành công!';
        $this->redirect('/admin/nodes');
    }

    public function detail(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $node = $id ? $this->nodeModel->find($id) : null;

        if (!$node) {
            $_SESSION['error'] = 'Nút kết nối không tồn tại!';
            $this->redirect('/admin/nodes');
            return;
        }

        $server = $this->serverModel->find($node['server_id']);
        if ($server) {
            $node['server_name']     = $server['name'];
            $node['server_ip']       = $server['ip_address'];
            $node['server_location'] = $server['location'];
        }

        $this->render('admin.nodes.detail', [
            'activeMenu' => 'nodes',
            'node'       => $node
        ]);
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) {
            $this->nodeModel->delete($id);
            $_SESSION['flash_message'] = 'Đã xóa nút kết nối thành công!';
        }
        $this->redirect('/admin/nodes');
    }
}
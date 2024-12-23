<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisTanaman;
use App\Models\Orders;
use App\Models\Users;

class ClientController extends BaseController
{
    public function index($username)
    {
        $userModel = new Users();
        $orderModel = new Orders();
        $jenisModel = new JenisTanaman();
        
        if ($this->request->isAJAX() && $this->request->getMethod(true) === 'POST') {
            $data = [
                'id_user'  => session()->get('id'),
                'deskripsi_db'   => $this->request->getPost('deskripsi_db'),
                'tanggal_db'   => $this->request->getPost('tanggal_db'),
                'perbaikan'   => $this->request->getPost('perbaikan'),
                'kategori'   => $this->request->getPost('kategori'),
                'admin'   => $this->request->getPost('admin'),
            ];
            
            $saved = $orderModel->save($data);
            $status = $saved ? 'success' : 'error';
            $text = $saved ? 'Berhasil menyimpan data temuan.' : 'Gagal menyimpan data temuan.';
            
            return $this->response->setJSON([
                'status' => $saved,
                'icon' => $status,
                'title' => ucfirst($status) . '!',
                'text' => $text,
            ]);
        }
        
        $content = [];
        $jenis = [];
        $admin = [];
        $page = '';
        
        if ($this->request->getMethod(true) === 'GET') {
            $role = session()->get('role');
            $content = $orderModel->getOrderByIdUser(session()->get('id'));
            $admin = $userModel->getUserWithParams('admin');
            $page = 'Daftar Temuan';
            $jenis = $jenisModel->findAll();
        }
        
        $data = compact('content', 'jenis', 'admin', 'page');
        
        return view('pages/clientDashboard', $data);
    }
}

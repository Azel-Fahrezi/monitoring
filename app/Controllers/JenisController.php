<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisTanaman;

class JenisController extends BaseController
{
    public function index()
    {
        $jenisTanamanModel = new JenisTanaman();
        $postData = $this->request->getPost();

        if (!empty($postData)) {
            $saved = $jenisTanamanModel->save($postData);
            $status = $saved ? [
                'status' => true,
                'icon' => 'success',
                'title' => 'Success!',
                'text' => 'Berhasil menyimpan data kategori.',
            ] : [
                'status' => false,
                'icon' => 'error',
                'title' => 'Warning!',
                'text' => 'Gagal menyimpan data kategori.',
            ];

            return $this->response->setJSON($status);
        }

        $jenisTanaman = $jenisTanamanModel->findAll();
        $data = [
            'content' => $jenisTanaman,
            'page' => 'Daftar Kategori'
        ];
        return view('pages/jenisDashboard', $data);
    }


    public function update($id)
    {
        $model = new JenisTanaman();
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($this->request->isAJAX() && $this->request->getMethod(true) === 'POST') {
            $result = $model->update($id, $data);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => 'Berhasil menyimpan data kategori.',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'icon' => 'error',
                    'title' => 'Warning!',
                    'text' => 'Gagal menyimpan data kategori.',
                ]);
            }
        } elseif ($this->request->isAJAX() && $this->request->getMethod(true) === 'GET') {
            $data['data'] = $model->find($id);
            return $this->response->setJSON($data);
        }
    }

    public function delete($id)
    {
        $model = new JenisTanaman();
        if ($this->request->isAJAX()) {
            $deleted = $model->delete($id);
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => true,
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => 'Berhasil hapus data kategori.',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'icon' => 'error',
                    'title' => 'Warning!',
                    'text' => 'Gagal hapus data kategori.',
                ]);
            }
        }
    }
}

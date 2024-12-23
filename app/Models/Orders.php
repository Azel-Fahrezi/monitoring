<?php

namespace App\Models;

use CodeIgniter\Model;

class Orders extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'temuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user',
        'deskripsi_db',
        'tanggal_db',
        'perbaikan',
        'kategori',
        'admin',
        'status',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getOrders()
    {
        return $this->db->table('temuan')
            ->select('
                users.name,
                kategori.nama_kategori as jenis,
                temuan.*
            ')
            ->join('users', 'temuan.id_user = users.id')
            ->join('kategori', 'temuan.kategori = kategori.id')
            ->get()->getResult();
    }

    function getOrdersByAdmin($id)
    {
        return $this->db->table('temuan')
            ->select('
                users.name,
                kategori.nama_kategori as jenis,
                temuan.*
            ')
            ->join('users', 'temuan.id_user = users.id')
            ->join('kategori', 'temuan.kategori = kategori.id')
            ->where('temuan.admin', $id)
            ->get()->getResult();
    }
    
    function getOrderByID($id) 
    {
        return $this->db
            ->table('temuan')
            ->select('users.name, kategori.nama_kategori as jenis, temuan.*')
            ->join('users', 'temuan.id_user = users.id')
            ->join('kategori', 'temuan.kategori = kategori.id')
            ->where('temuan.id', $id)
            ->get()
            ->getResult();
    }
    

    function getOrderByIdUser($id)
    {
        return $this->db->table('temuan')
            ->select('
                users.name,
                kategori.nama_kategori as jenis,
                temuan.*
            ')
            ->join('users', 'temuan.id_user = users.id')
            ->join('kategori', 'temuan.kategori = kategori.id')
            ->where('temuan.id_user', $id)
            ->get()->getResult();
    }

    function findDataInBetweenByUsersId($start, $end, $id)
    {
        return $this->db->table('temuan')
            ->select('
                users.name,
                kategori.nama_kategori as jenis,
                temuan.*
            ')
            ->join('users', 'temuan.id_user = users.id')
            ->join('kategori', 'temuan.kategori = kategori.id')
            ->where('temuan.admin', $id)
            ->where("temuan.tanggal_db BETWEEN '$start' AND '$end'")
            ->get()
            ->getResultArray();
    }
}

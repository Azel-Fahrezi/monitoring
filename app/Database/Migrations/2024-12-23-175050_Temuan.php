<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Temuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'deskripsi_db' => [
                'type' => 'TEXT',
            ],
            'tanggal_db' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'nomor_user' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'perbaikan' => [
                'type' => 'TEXT'
            ],
            'kategori' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'admin' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'status' => [
                'type' => 'ENUM("selesai","dalam_progres","menunggu_konfirmasi")',
                'default' => 'menunggu_konfirmasi',
                'null' => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('temuan');
    }

    public function down()
    {
        $this->forge->dropTable('temuan');
    }
}

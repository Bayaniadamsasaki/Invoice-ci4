<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRoleSystem extends Migration
{
    public function up()
    {
        // Update data role yang ada
        $db = \Config\Database::connect();
        
        // Update role admin tetap sebagai admin
        $db->table('login')
            ->where('username', 'admin')
            ->update(['role' => 'admin']);
        
        // Update role user menjadi bagian_keuangan
        $db->table('login')
            ->where('username', 'user')
            ->update(['role' => 'bagian_keuangan']);
        
        // Tambah user manager baru
        $data = [
            'username' => 'manager',
            'password' => password_hash('manager123', PASSWORD_DEFAULT),
            'role' => 'manager',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $db->table('login')->insert($data);
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // Kembalikan ke kondisi awal
        $db->table('login')
            ->where('username', 'user')
            ->update(['role' => 'user']);
            
        $db->table('login')
            ->where('username', 'manager')
            ->delete();
    }
}

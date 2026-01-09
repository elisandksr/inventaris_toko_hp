<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'nama_admin' => 'Administrator',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Check if admin exists
        $db = \Config\Database::connect();
        if ($db->table('admins')->where('username', 'admin')->countAllResults() == 0) {
            $this->db->table('admins')->insert($data);
        }
    }
}

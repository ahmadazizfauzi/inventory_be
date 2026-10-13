<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // 1. Superadmin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@demo.com',
            'password' => $defaultPassword,
            'role' => 'superadmin',
        ]);

        // 2. Admin Utama
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@demo.com',
            'password' => $defaultPassword,
            'role' => 'admin',
        ]);

        // 3. 10 Demo Admin Staff
        $adminNames = [
            'Budi Santoso', 'Siti Rahmawati', 'Agus Prasetyo', 'Dewi Lestari', 'Eko Wibowo',
            'Rina Wijaya', 'Fajar Ramadhan', 'Nurul Hidayah', 'Bambang Irawan', 'Dian Anggraini',
        ];
        foreach ($adminNames as $index => $name) {
            $slug = strtolower(str_replace(' ', '.', $name));
            User::create([
                'name' => $name,
                'email' => "admin.{$slug}".($index + 1).'@demo.com',
                'password' => $defaultPassword,
                'role' => 'admin',
            ]);
        }

        // 4. Staff Gudang Utama
        User::create([
            'name' => 'Staff Gudang Utama',
            'email' => 'staff@demo.com',
            'password' => $defaultPassword,
            'role' => 'staff',
        ]);

        // 5. 10 Demo Warehouse Staff
        $staffNames = [
            'Adi Nugroho', 'Rizky Pratama', 'Indah Permata', 'Wahyu Hidayat', 'Bayu Saputra',
            'Putri Ayu', 'Dimas Wicaksono', 'Anisa Fitri', 'Yusuf Maulana', 'Lestari Handayani',
        ];
        foreach ($staffNames as $index => $name) {
            $slug = strtolower(str_replace(' ', '.', $name));
            User::create([
                'name' => $name,
                'email' => "staff.{$slug}".($index + 1).'@demo.com',
                'password' => $defaultPassword,
                'role' => 'staff',
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\StaffGudang;
use App\Models\StaffArmada;
use App\Models\ManajerOperasional;
use App\Models\Armada;
use App\Models\Supir;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        $adminUser = User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@sismodo.com',
            'role' => 'admin',
            'password' => Hash::make('password'), // Password default
        ]);
        
        Admin::create([
            'user_id' => $adminUser->id,
        ]);

        // 2. Buat Akun STAFF GUDANG
        $gudangUser = User::create([
            'name' => 'Budi Staff Gudang',
            'email' => 'gudang@sismodo.com',
            'role' => 'staff_gudang',
            'password' => Hash::make('password'),
        ]);

        StaffGudang::create([
            'user_id' => $gudangUser->id,
            'area_gudang' => 'Gudang Pusat A',
        ]);

        // 3. Buat Akun STAFF ARMADA
        $armadaUser = User::create([
            'name' => 'Siti Staff Armada',
            'email' => 'armada@sismodo.com',
            'role' => 'staff_armada',
            'password' => Hash::make('password'),
        ]);

        StaffArmada::create([
            'user_id' => $armadaUser->id,
            'area_operasi' => 'Jabodetabek',
        ]);

        // 4. Buat Akun MANAJER OPERASIONAL
        $manajerUser = User::create([
            'name' => 'Pak Bos Manajer',
            'email' => 'manajer@sismodo.com',
            'role' => 'manajer',
            'password' => Hash::make('password'),
        ]);

        ManajerOperasional::create([
            'user_id' => $manajerUser->id,
        ]);

        // 5. Buat Data Dummy ARMADA
        Armada::create([
            'nomor_plat' => 'B 1234 XYZ',
            'jenis_kendaraan' => 'Truk Box CDD',
            'kapasitas' => 4000, // kg
            'status' => 'Tersedia',
        ]);

        Armada::create([
            'nomor_plat' => 'D 5678 ABC',
            'jenis_kendaraan' => 'Blind Van',
            'kapasitas' => 700, // kg
            'status' => 'Tersedia',
        ]);

        // 6. Buat Data Dummy SUPIR
        Supir::create([
            'nama_sopir' => 'Asep Driver',
            'nomor_sim' => '123456789012',
            'nomor_telepon' => '08123456789',
            'status' => 'Aktif',
        ]);

        Supir::create([
            'nama_sopir' => 'Ujang Driver',
            'nomor_sim' => '987654321098',
            'nomor_telepon' => '08198765432',
            'status' => 'Aktif',
        ]);
    }
}
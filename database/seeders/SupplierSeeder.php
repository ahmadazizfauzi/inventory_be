<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Sumber Pangan Nusantara', 'phone' => '021-5566778', 'email' => 'sales@sumberpangan.co.id', 'address' => 'Kawasan Industri Pulogadung Blok A5, Jakarta Timur'],
            ['name' => 'CV Berkah Makmur Abadi', 'phone' => '031-8971234', 'email' => 'distribusi@berkahmakmur.com', 'address' => 'Jl. Rungkut Industri No. 42, Surabaya'],
            ['name' => 'PT Sinar Terang Distribusi', 'phone' => '021-6543210', 'email' => 'order@sinarterang.co.id', 'address' => 'Komplek Pergudangan Daan Mogot KM 12, Jakarta Barat'],
            ['name' => 'CV Mitra Jaya Stationery', 'phone' => '022-7201987', 'email' => 'mitrajaya.atk@gmail.com', 'address' => 'Jl. Soekarno Hatta No. 128, Bandung'],
            ['name' => 'PT Sejahtera Tekstil Pratama', 'phone' => '0274-889900', 'email' => 'tekstil@sejahtera.co.id', 'address' => 'Jl. Ring Road Utara Kav. 8, Sleman, Yogyakarta'],
            ['name' => 'Toko Grosir Sembako Rejeki', 'phone' => '024-7654321', 'email' => 'grosir.rejeki@yahoo.com', 'address' => 'Pasar Induk Johar Blok C No. 15, Semarang'],
            ['name' => 'PT Indah Cipta Mandiri', 'phone' => '021-8899776', 'email' => 'houseware@indahcipta.com', 'address' => 'Kawasan Pergudangan Harapan Indah Blok B, Bekasi'],
            ['name' => 'CV Harapan Sentosa Jaya', 'phone' => '031-5432190', 'email' => 'harapansentosa@gmail.com', 'address' => 'Jl. Margomulyo Indah Blok D-11, Surabaya'],
            ['name' => 'CV Pelita Surya Perkasa', 'phone' => '061-4561234', 'email' => 'pelitasurya@medan.co.id', 'address' => 'Jl. Krakatau Raya No. 90, Medan'],
            ['name' => 'PT Aneka Niaga Lestari', 'phone' => '021-3456789', 'email' => 'info@anekanikaga.id', 'address' => 'Jl. Gatot Subroto Kav. 55, Jakarta Selatan'],
        ];

        foreach ($suppliers as $data) {
            Supplier::create($data);
        }
    }
}

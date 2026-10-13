<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sembako & Bahan Pokok', 'description' => 'Beras, minyak goreng, gula, tepung, dan kebutuhan pokok'],
            ['name' => 'Minuman & Kopi', 'description' => 'Kopi, teh, susu kemasan, dan aneka minuman konsumsi'],
            ['name' => 'Makanan Ringan & Biskuit', 'description' => 'Camilan, biskuit, keripik, dan aneka snack'],
            ['name' => 'Perlengkapan Mandi & Cuci', 'description' => 'Sabun, sampo, pasta gigi, dan deterjen pembersih'],
            ['name' => 'Alat Tulis Kantor (ATK)', 'description' => 'Kertas HVS, pulpen, spidol, dan perlengkapan arsip'],
            ['name' => 'Pakaian & Tekstil', 'description' => 'Kaos polos, kemeja kerja, handuk, dan pakaian katun'],
            ['name' => 'Alat Dapur & Memasak', 'description' => 'Wajan anti lengket, panci stainless, dan perlengkapan masak'],
            ['name' => 'Perabotan Rumah Tangga', 'description' => 'Sapu, ember plastik, lap kanebo, dan kebersihan rumah'],
        ];

        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}

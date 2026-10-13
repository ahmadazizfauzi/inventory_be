<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::orderBy('id')->get();

        $productsCatalog = [
            // Sembako (Cat index 0)
            ['cat' => 0, 'sku' => 'PRD-001', 'name' => 'Beras Pandan Wangi Premium 5kg', 'buy' => 68000, 'sell' => 78000, 'stock' => 35, 'min' => 10],
            ['cat' => 0, 'sku' => 'PRD-002', 'name' => 'Minyak Goreng Sawit Pouch 2 Liter', 'buy' => 32000, 'sell' => 37500, 'stock' => 50, 'min' => 15],
            ['cat' => 0, 'sku' => 'PRD-003', 'name' => 'Gula Pasir Kristal Putih 1kg', 'buy' => 14500, 'sell' => 17000, 'stock' => 40, 'min' => 10],
            ['cat' => 0, 'sku' => 'PRD-004', 'name' => 'Tepung Terigu Serbaguna 1kg', 'buy' => 11000, 'sell' => 13500, 'stock' => 25, 'min' => 8],

            // Minuman & Kopi (Cat index 1)
            ['cat' => 1, 'sku' => 'PRD-005', 'name' => 'Kopi Arabika Bubuk Murni 250gr', 'buy' => 35000, 'sell' => 45000, 'stock' => 20, 'min' => 5],
            ['cat' => 1, 'sku' => 'PRD-006', 'name' => 'Teh Celup Hitam Melati Isi 25', 'buy' => 6500, 'sell' => 8500, 'stock' => 4, 'min' => 10], // Low stock
            ['cat' => 1, 'sku' => 'PRD-007', 'name' => 'Susu Sapi UHT Full Cream 1 Liter', 'buy' => 17500, 'sell' => 21000, 'stock' => 30, 'min' => 8],
            ['cat' => 1, 'sku' => 'PRD-008', 'name' => 'Air Mineral Galon 19 Liter', 'buy' => 19000, 'sell' => 23000, 'stock' => 15, 'min' => 5],

            // Makanan Ringan (Cat index 2)
            ['cat' => 2, 'sku' => 'PRD-009', 'name' => 'Biskuit Cokelat Kaleng 300gr', 'buy' => 28000, 'sell' => 35000, 'stock' => 18, 'min' => 5],
            ['cat' => 2, 'sku' => 'PRD-010', 'name' => 'Keripik Singkong Renyah Balado 200gr', 'buy' => 12000, 'sell' => 16000, 'stock' => 22, 'min' => 6],
            ['cat' => 2, 'sku' => 'PRD-011', 'name' => 'Wafer Krim Cokelat Roll 150gr', 'buy' => 8500, 'sell' => 11500, 'stock' => 0, 'min' => 5], // Out of stock

            // Perlengkapan Mandi & Cuci (Cat index 3)
            ['cat' => 3, 'sku' => 'PRD-012', 'name' => 'Sabun Mandi Cair Botol 450ml', 'buy' => 18000, 'sell' => 23000, 'stock' => 28, 'min' => 8],
            ['cat' => 3, 'sku' => 'PRD-013', 'name' => 'Shampo Rambut Sehat 340ml', 'buy' => 27000, 'sell' => 34000, 'stock' => 16, 'min' => 5],
            ['cat' => 3, 'sku' => 'PRD-014', 'name' => 'Deterjen Bubuk Bersih Harum 800gr', 'buy' => 19500, 'sell' => 24500, 'stock' => 35, 'min' => 10],
            ['cat' => 3, 'sku' => 'PRD-015', 'name' => 'Pasta Gigi Herbal Perlindungan 190gr', 'buy' => 12500, 'sell' => 16000, 'stock' => 3, 'min' => 8], // Low stock

            // Alat Tulis Kantor (Cat index 4)
            ['cat' => 4, 'sku' => 'PRD-016', 'name' => 'Kertas HVS Putih A4 80gr 1 Rim', 'buy' => 45000, 'sell' => 55000, 'stock' => 40, 'min' => 10],
            ['cat' => 4, 'sku' => 'PRD-017', 'name' => 'Pulpen Gel Tinta Hitam 0.5mm 1 Lusin', 'buy' => 24000, 'sell' => 32000, 'stock' => 25, 'min' => 6],
            ['cat' => 4, 'sku' => 'PRD-018', 'name' => 'Spidol Papan Tulis Hitam 1 Kotak', 'buy' => 65000, 'sell' => 82000, 'stock' => 12, 'min' => 4],
            ['cat' => 4, 'sku' => 'PRD-019', 'name' => 'Map Arsip Dokumen Plastik 1 Lusin', 'buy' => 28000, 'sell' => 38000, 'stock' => 50, 'min' => 15],

            // Pakaian & Tekstil (Cat index 5)
            ['cat' => 5, 'sku' => 'PRD-020', 'name' => 'Kaos Polos Katun Combed 30s Hitam', 'buy' => 38000, 'sell' => 55000, 'stock' => 30, 'min' => 10],
            ['cat' => 5, 'sku' => 'PRD-021', 'name' => 'Kemeja Polos Formal Putih Lengan Panjang', 'buy' => 85000, 'sell' => 120000, 'stock' => 14, 'min' => 5],
            ['cat' => 5, 'sku' => 'PRD-022', 'name' => 'Handuk Mandi Katun Lembut 70x140cm', 'buy' => 45000, 'sell' => 65000, 'stock' => 18, 'min' => 5],

            // Alat Dapur (Cat index 6)
            ['cat' => 6, 'sku' => 'PRD-023', 'name' => 'Wajan Teflon Anti Lengket 24cm', 'buy' => 75000, 'sell' => 105000, 'stock' => 9, 'min' => 3],
            ['cat' => 6, 'sku' => 'PRD-024', 'name' => 'Panci Masak Stainless Steel 20cm', 'buy' => 68000, 'sell' => 95000, 'stock' => 11, 'min' => 4],

            // Perabotan Rumah Tangga (Cat index 7)
            ['cat' => 7, 'sku' => 'PRD-025', 'name' => 'Sapu Lantai Nilon Gagang Besi', 'buy' => 22000, 'sell' => 30000, 'stock' => 20, 'min' => 5],
        ];

        foreach ($productsCatalog as $item) {
            Product::create([
                'category_id' => $categories[$item['cat']]->id,
                'sku' => $item['sku'],
                'name' => $item['name'],
                'purchase_price' => $item['buy'],
                'selling_price' => $item['sell'],
                'stock' => $item['stock'],
                'min_stock' => $item['min'],
            ]);
        }
    }
}

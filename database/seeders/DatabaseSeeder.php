<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMutation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // Seed initial demo accounts and general retail/consumer inventory catalog
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // 1. Seed Users (Superadmin, Admin, Staff)
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@demo.com',
            'password' => $defaultPassword,
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@demo.com',
            'password' => $defaultPassword,
            'role' => 'admin',
        ]);

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

        User::create([
            'name' => 'Staff Gudang Utama',
            'email' => 'staff@demo.com',
            'password' => $defaultPassword,
            'role' => 'staff',
        ]);

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

        // 2. Seed 8 General Categories (Mudah dipahami, barang sehari-hari)
        $categoryData = [
            ['name' => 'Sembako & Bahan Pokok', 'description' => 'Beras, minyak goreng, gula, tepung, dan kebutuhan pokok'],
            ['name' => 'Minuman & Kopi', 'description' => 'Kopi, teh, susu kemasan, dan aneka minuman konsumsi'],
            ['name' => 'Makanan Ringan & Biskuit', 'description' => 'Camilan, biskuit, keripik, dan aneka snack'],
            ['name' => 'Perlengkapan Mandi & Cuci', 'description' => 'Sabun, sampo, pasta gigi, dan deterjen pembersih'],
            ['name' => 'Alat Tulis Kantor (ATK)', 'description' => 'Kertas HVS, pulpen, spidol, dan perlengkapan arsip'],
            ['name' => 'Pakaian & Tekstil', 'description' => 'Kaos polos, kemeja kerja, handuk, dan pakaian katun'],
            ['name' => 'Alat Dapur & Memasak', 'description' => 'Wajan anti lengket, panci stainless, dan perlengkapan masak'],
            ['name' => 'Perabotan Rumah Tangga', 'description' => 'Sapu, ember plastik, lap kanebo, dan kebersihan rumah'],
        ];

        $categories = [];
        foreach ($categoryData as $data) {
            $categories[] = Category::create($data);
        }

        // 3. Seed 10 General Suppliers (Pemasok barang umum dan distributor retail)
        $supplierData = [
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

        $suppliers = [];
        foreach ($supplierData as $data) {
            $suppliers[] = Supplier::create($data);
        }

        // 4. Seed 25 General Everyday Products (PRD-001 ... PRD-025)
        $productsCatalog = [
            // Sembako (Cat 0)
            ['cat' => 0, 'sku' => 'PRD-001', 'name' => 'Beras Pandan Wangi Premium 5kg', 'buy' => 68000, 'sell' => 78000, 'stock' => 35, 'min' => 10],
            ['cat' => 0, 'sku' => 'PRD-002', 'name' => 'Minyak Goreng Sawit Pouch 2 Liter', 'buy' => 32000, 'sell' => 37500, 'stock' => 50, 'min' => 15],
            ['cat' => 0, 'sku' => 'PRD-003', 'name' => 'Gula Pasir Kristal Putih 1kg', 'buy' => 14500, 'sell' => 17000, 'stock' => 40, 'min' => 10],
            ['cat' => 0, 'sku' => 'PRD-004', 'name' => 'Tepung Terigu Serbaguna 1kg', 'buy' => 11000, 'sell' => 13500, 'stock' => 25, 'min' => 8],

            // Minuman & Kopi (Cat 1)
            ['cat' => 1, 'sku' => 'PRD-005', 'name' => 'Kopi Arabika Bubuk Murni 250gr', 'buy' => 35000, 'sell' => 45000, 'stock' => 20, 'min' => 5],
            ['cat' => 1, 'sku' => 'PRD-006', 'name' => 'Teh Celup Hitam Melati Isi 25', 'buy' => 6500, 'sell' => 8500, 'stock' => 4, 'min' => 10], // Low stock
            ['cat' => 1, 'sku' => 'PRD-007', 'name' => 'Susu Sapi UHT Full Cream 1 Liter', 'buy' => 17500, 'sell' => 21000, 'stock' => 30, 'min' => 8],
            ['cat' => 1, 'sku' => 'PRD-008', 'name' => 'Air Mineral Galon 19 Liter', 'buy' => 19000, 'sell' => 23000, 'stock' => 15, 'min' => 5],

            // Makanan Ringan (Cat 2)
            ['cat' => 2, 'sku' => 'PRD-009', 'name' => 'Biskuit Cokelat Kaleng 300gr', 'buy' => 28000, 'sell' => 35000, 'stock' => 18, 'min' => 5],
            ['cat' => 2, 'sku' => 'PRD-010', 'name' => 'Keripik Singkong Renyah Balado 200gr', 'buy' => 12000, 'sell' => 16000, 'stock' => 22, 'min' => 6],
            ['cat' => 2, 'sku' => 'PRD-011', 'name' => 'Wafer Krim Cokelat Roll 150gr', 'buy' => 8500, 'sell' => 11500, 'stock' => 0, 'min' => 5], // Out of stock

            // Perlengkapan Mandi & Cuci (Cat 3)
            ['cat' => 3, 'sku' => 'PRD-012', 'name' => 'Sabun Mandi Cair Botol 450ml', 'buy' => 18000, 'sell' => 23000, 'stock' => 28, 'min' => 8],
            ['cat' => 3, 'sku' => 'PRD-013', 'name' => 'Shampo Rambut Sehat 340ml', 'buy' => 27000, 'sell' => 34000, 'stock' => 16, 'min' => 5],
            ['cat' => 3, 'sku' => 'PRD-014', 'name' => 'Deterjen Bubuk Bersih Harum 800gr', 'buy' => 19500, 'sell' => 24500, 'stock' => 35, 'min' => 10],
            ['cat' => 3, 'sku' => 'PRD-015', 'name' => 'Pasta Gigi Herbal Perlindungan 190gr', 'buy' => 12500, 'sell' => 16000, 'stock' => 3, 'min' => 8], // Low stock

            // Alat Tulis Kantor (Cat 4)
            ['cat' => 4, 'sku' => 'PRD-016', 'name' => 'Kertas HVS Putih A4 80gr 1 Rim', 'buy' => 45000, 'sell' => 55000, 'stock' => 40, 'min' => 10],
            ['cat' => 4, 'sku' => 'PRD-017', 'name' => 'Pulpen Gel Tinta Hitam 0.5mm 1 Lusin', 'buy' => 24000, 'sell' => 32000, 'stock' => 25, 'min' => 6],
            ['cat' => 4, 'sku' => 'PRD-018', 'name' => 'Spidol Papan Tulis Hitam 1 Kotak', 'buy' => 65000, 'sell' => 82000, 'stock' => 12, 'min' => 4],
            ['cat' => 4, 'sku' => 'PRD-019', 'name' => 'Map Arsip Dokumen Plastik 1 Lusin', 'buy' => 28000, 'sell' => 38000, 'stock' => 50, 'min' => 15],

            // Pakaian & Tekstil (Cat 5)
            ['cat' => 5, 'sku' => 'PRD-020', 'name' => 'Kaos Polos Katun Combed 30s Hitam', 'buy' => 38000, 'sell' => 55000, 'stock' => 30, 'min' => 10],
            ['cat' => 5, 'sku' => 'PRD-021', 'name' => 'Kemeja Polos Formal Putih Lengan Panjang', 'buy' => 85000, 'sell' => 120000, 'stock' => 14, 'min' => 5],
            ['cat' => 5, 'sku' => 'PRD-022', 'name' => 'Handuk Mandi Katun Lembut 70x140cm', 'buy' => 45000, 'sell' => 65000, 'stock' => 18, 'min' => 5],

            // Alat Dapur (Cat 6)
            ['cat' => 6, 'sku' => 'PRD-023', 'name' => 'Wajan Teflon Anti Lengket 24cm', 'buy' => 75000, 'sell' => 105000, 'stock' => 9, 'min' => 3],
            ['cat' => 6, 'sku' => 'PRD-024', 'name' => 'Panci Masak Stainless Steel 20cm', 'buy' => 68000, 'sell' => 95000, 'stock' => 11, 'min' => 4],

            // Perabotan Rumah Tangga (Cat 7)
            ['cat' => 7, 'sku' => 'PRD-025', 'name' => 'Sapu Lantai Nilon Gagang Besi', 'buy' => 22000, 'sell' => 30000, 'stock' => 20, 'min' => 5],
        ];

        $products = [];
        foreach ($productsCatalog as $item) {
            $products[] = Product::create([
                'category_id' => $categories[$item['cat']]->id,
                'sku' => $item['sku'],
                'name' => $item['name'],
                'purchase_price' => $item['buy'],
                'selling_price' => $item['sell'],
                'stock' => $item['stock'],
                'min_stock' => $item['min'],
            ]);
        }

        // 5. Seed Historical Stock Mutations (Transaksi realistis)
        $adminUser = User::where('role', 'admin')->first();
        $staffUser = User::where('role', 'staff')->first();

        $mutationsSample = [
            ['prod' => 0, 'sup' => 0, 'type' => 'in', 'qty' => 50, 'note' => 'Penerimaan pasokan beras dari PT Sumber Pangan Nusantara'],
            ['prod' => 0, 'sup' => null, 'type' => 'out', 'qty' => 15, 'note' => 'Pengiriman beras pesanan toko cabang'],
            ['prod' => 1, 'sup' => 0, 'type' => 'in', 'qty' => 60, 'note' => 'Restock minyak goreng 2L dari distributor'],
            ['prod' => 1, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Penjualan grosir minyak goreng'],
            ['prod' => 2, 'sup' => 0, 'type' => 'in', 'qty' => 50, 'note' => 'Penerimaan gula pasir kristal putih'],
            ['prod' => 2, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Distribusi gula pasir ke display penjualan'],
            ['prod' => 4, 'sup' => 1, 'type' => 'in', 'qty' => 30, 'note' => 'Pengadaan kopi bubuk Arabika dari CV Berkah Makmur'],
            ['prod' => 4, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Pengambilan sampel dan penjualan outlet'],
            ['prod' => 6, 'sup' => 1, 'type' => 'in', 'qty' => 40, 'note' => 'Restock susu UHT Full Cream 1L'],
            ['prod' => 6, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Distribusi susu kemasan ke rak toko'],
            ['prod' => 8, 'sup' => 1, 'type' => 'in', 'qty' => 25, 'note' => 'Penerimaan biskuit cokelat kaleng'],
            ['prod' => 8, 'sup' => null, 'type' => 'out', 'qty' => 7, 'note' => 'Penjualan paket parsel biskuit'],
            ['prod' => 11, 'sup' => 2, 'type' => 'in', 'qty' => 40, 'note' => 'Restock sabun mandi cair dari PT Sinar Terang'],
            ['prod' => 11, 'sup' => null, 'type' => 'out', 'qty' => 12, 'note' => 'Penjualan retail sabun mandi'],
            ['prod' => 13, 'sup' => 2, 'type' => 'in', 'qty' => 50, 'note' => 'Penerimaan deterjen bubuk konsentrat'],
            ['prod' => 13, 'sup' => null, 'type' => 'out', 'qty' => 15, 'note' => 'Distribusi deterjen ke etalase'],
            ['prod' => 15, 'sup' => 3, 'type' => 'in', 'qty' => 50, 'note' => 'Pengadaan kertas HVS A4 dari CV Mitra Jaya'],
            ['prod' => 15, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Pemakaian operasional kantor dan cetak laporan'],
            ['prod' => 19, 'sup' => 4, 'type' => 'in', 'qty' => 40, 'note' => 'Penerimaan kaos polos katun hitam dari PT Sejahtera Tekstil'],
            ['prod' => 19, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Penjualan kaos katun ke customer retail'],
        ];

        foreach ($mutationsSample as $item) {
            $product = $products[$item['prod']];
            $supplier = $item['sup'] !== null ? $suppliers[$item['sup']] : null;
            $user = $item['type'] === 'in' ? $adminUser : $staffUser;

            StockMutation::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'supplier_id' => $supplier?->id,
                'type' => $item['type'],
                'quantity' => $item['qty'],
                'stock_before' => $product->stock,
                'stock_after' => $item['type'] === 'in' ? $product->stock + $item['qty'] : max(0, $product->stock - $item['qty']),
                'notes' => $item['note'],
            ]);
        }
    }
}

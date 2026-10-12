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
    // Seed initial demo accounts and inventory catalog
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // 1. Seed Users (1 Superadmin, 15 Admin, 20 Staff)
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
            'Hendra Kurniawan', 'Mega Putri', 'Aris Setiawan', 'Tri Wahyuni',
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
            'Rian Firmansyah', 'Winda Sari', 'Ilham Saputra', 'Fitri Handayani', 'Gilang Ramadan',
            'Maya Kusuma', 'Taufik Hidayat', 'Nadya Ulfah', 'Farhan Alamsyah',
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

        // 2. Seed 15 Categories
        $categoryData = [
            ['name' => 'Komputer & Laptop', 'description' => 'Perangkat PC desktop, all-in-one, dan laptop kantor'],
            ['name' => 'Monitor & Display', 'description' => 'Layar monitor kerja, proyektor, dan aksesoris display'],
            ['name' => 'Perangkat Jaringan', 'description' => 'Router, switch manageable, access point, dan mikrotik'],
            ['name' => 'Server & Storage', 'description' => 'Server rackmount, NAS storage, dan harddisk enterprise'],
            ['name' => 'Aksesoris Komputer', 'description' => 'Keyboard, mouse, mousepad, docking station, dan webcam'],
            ['name' => 'Kabel & Konektor', 'description' => 'Kabel LAN Cat6, kabel HDMI, DisplayPort, dan patch cord'],
            ['name' => 'Printer & Scanner', 'description' => 'Printer laser, printer barcode, scanner dokumen, dan toner'],
            ['name' => 'CCTV & Keamanan', 'description' => 'Kamera CCTV IP, NVR perekam, dan access door RFID'],
            ['name' => 'Peralatan Audio', 'description' => 'Speaker meeting, headset call center, dan mikrofon konferensi'],
            ['name' => 'UPS & Kelistrikan', 'description' => 'Uninterruptible power supply, PDU rack, dan stabilizer'],
            ['name' => 'Alat Tulis Kantor', 'description' => 'Kertas A4, map arsip, binder, dan perlengkapan dokumen'],
            ['name' => 'Furniture Kantor', 'description' => 'Kursi ergonomis, meja kerja, dan mobile drawer'],
            ['name' => 'Perkakas & Toolset', 'description' => 'Crimping tool, tester LAN, obeng set, dan kabel ties'],
            ['name' => 'Sparepart Komponen', 'description' => 'RAM DDR4/DDR5, SSD NVMe, power supply, dan pasta thermal'],
            ['name' => 'Logistik & Packaging', 'description' => 'Bubble wrap, kardus pengiriman, dan lakban fragile'],
        ];

        $categories = [];
        foreach ($categoryData as $data) {
            $categories[] = Category::create($data);
        }

        // 3. Seed 15 Suppliers
        $supplierData = [
            ['name' => 'PT Synnex Metrodata Indonesia', 'phone' => '021-29345800', 'email' => 'sales@metrodata.co.id', 'address' => 'Jl. S. Parman Kav. 32-34, Jakarta Barat'],
            ['name' => 'PT Tera Data Indonusa', 'phone' => '031-5678912', 'email' => 'info@teradata.co.id', 'address' => 'Jl. Mayjen Sungkono No. 88, Surabaya'],
            ['name' => 'PT Astrindo Senayasa', 'phone' => '021-6121330', 'email' => 'contact@astrindo.co.id', 'address' => 'Mangga Dua Square Blok F, Jakarta Pusat'],
            ['name' => 'PT Berca Hardayaperkasa', 'phone' => '021-3800902', 'email' => 'enterprise@berca.co.id', 'address' => 'Jl. Abdul Muis No. 62, Jakarta Pusat'],
            ['name' => 'PT Multipolar Technology', 'phone' => '021-5460011', 'email' => 'support@multipolar.com', 'address' => 'Lippo Karawaci Boulevard, Tangerang'],
            ['name' => 'PT Sistech Kharisma', 'phone' => '021-6530668', 'email' => 'distribution@sistech.co.id', 'address' => 'Sunter Agung Podomoro, Jakarta Utara'],
            ['name' => 'PT Harrisma Informatika Jaya', 'phone' => '021-7278788', 'email' => 'sales@harrisma.com', 'address' => 'Jl. Radio Dalam Raya No. 4, Jakarta Selatan'],
            ['name' => 'PT ECS Indo Jaya', 'phone' => '021-6231289', 'email' => 'partner@ecsindo.com', 'address' => 'Komplek Harco Mangga Dua, Jakarta Pusat'],
            ['name' => 'PT Graha Sumber Prima Elektronik', 'phone' => '022-4235889', 'email' => 'bandung@gspe.co.id', 'address' => 'Jl. Naripan No. 45, Bandung'],
            ['name' => 'PT Jayatama Selaras Distribusi', 'phone' => '024-8451200', 'email' => 'semarang@jayatama.co.id', 'address' => 'Jl. Pemuda No. 120, Semarang'],
            ['name' => 'Toko Grosir Komputer Jaya', 'phone' => '031-8419200', 'email' => 'grosir.jaya@gmail.com', 'address' => 'Hitech Mall Lt. 1, Surabaya'],
            ['name' => 'CV Berkah Mandiri Office', 'phone' => '0274-512800', 'email' => 'berkah.office@gmail.com', 'address' => 'Jl. Gejayan No. 18, Yogyakarta'],
            ['name' => 'PT Triputra Mega Persada', 'phone' => '061-4567890', 'email' => 'medan@triputra.co.id', 'address' => 'Jl. Gatot Subroto No. 200, Medan'],
            ['name' => 'PT Solusi Jaringan Prima', 'phone' => '021-8899123', 'email' => 'network@solusiprima.id', 'address' => 'Harapan Indah Blok CA, Bekasi'],
            ['name' => 'CV Duta Office Solution', 'phone' => '021-8612345', 'email' => 'dutaoffice@gmail.com', 'address' => 'Jl. Pemuda No. 70, Jakarta Timur'],
        ];

        $suppliers = [];
        foreach ($supplierData as $data) {
            $suppliers[] = Supplier::create($data);
        }

        // 4. Seed 25 Products with Simple SKUs (PRD-001 ... PRD-025)
        $productsCatalog = [
            ['cat' => 0, 'sku' => 'PRD-001', 'name' => 'Laptop Lenovo ThinkPad E14 Gen 5', 'buy' => 11500000, 'sell' => 13200000, 'stock' => 12, 'min' => 5],
            ['cat' => 0, 'sku' => 'PRD-002', 'name' => 'PC Desktop HP Pro Tower 280 G9', 'buy' => 8700000, 'sell' => 10100000, 'stock' => 8, 'min' => 4],
            ['cat' => 1, 'sku' => 'PRD-003', 'name' => 'Monitor LG 24 Inch IPS 75Hz (24MP400)', 'buy' => 1350000, 'sell' => 1650000, 'stock' => 20, 'min' => 5],
            ['cat' => 1, 'sku' => 'PRD-004', 'name' => 'Monitor Dell 27 Inch 4K UHD (S2721QS)', 'buy' => 4200000, 'sell' => 4950000, 'stock' => 3, 'min' => 4], // Low stock
            ['cat' => 2, 'sku' => 'PRD-005', 'name' => 'Switch Manageable Cisco Catalyst 24 Port', 'buy' => 6800000, 'sell' => 8200000, 'stock' => 5, 'min' => 3],
            ['cat' => 2, 'sku' => 'PRD-006', 'name' => 'Router MikroTik CCR1009-7G-1C-1S+', 'buy' => 7200000, 'sell' => 8600000, 'stock' => 2, 'min' => 3], // Low stock
            ['cat' => 2, 'sku' => 'PRD-007', 'name' => 'Access Point Ubiquiti UniFi 6 Pro', 'buy' => 2450000, 'sell' => 2950000, 'stock' => 14, 'min' => 5],
            ['cat' => 3, 'sku' => 'PRD-008', 'name' => 'Server Dell PowerEdge R450 Rack 1U', 'buy' => 38500000, 'sell' => 44000000, 'stock' => 2, 'min' => 2],
            ['cat' => 3, 'sku' => 'PRD-009', 'name' => 'NAS Synology DS923+ 4-Bay', 'buy' => 8900000, 'sell' => 10500000, 'stock' => 4, 'min' => 3],
            ['cat' => 4, 'sku' => 'PRD-010', 'name' => 'Keyboard Mechanical Logitech K835 TKL', 'buy' => 520000, 'sell' => 690000, 'stock' => 25, 'min' => 8],
            ['cat' => 4, 'sku' => 'PRD-011', 'name' => 'Mouse Wireless Logitech M331 Silent', 'buy' => 165000, 'sell' => 225000, 'stock' => 40, 'min' => 10],
            ['cat' => 4, 'sku' => 'PRD-012', 'name' => 'Webcam Full HD 1080p Logitech C920', 'buy' => 950000, 'sell' => 1250000, 'stock' => 7, 'min' => 5],
            ['cat' => 5, 'sku' => 'PRD-013', 'name' => 'Kabel UTP Belden Cat6 305 Meter Box', 'buy' => 1850000, 'sell' => 2200000, 'stock' => 6, 'min' => 4],
            ['cat' => 5, 'sku' => 'PRD-014', 'name' => 'Kabel HDMI 2.1 Braided 3 Meter 8K', 'buy' => 95000, 'sell' => 145000, 'stock' => 30, 'min' => 10],
            ['cat' => 6, 'sku' => 'PRD-015', 'name' => 'Printer Epson EcoTank L3210 All-in-One', 'buy' => 2200000, 'sell' => 2650000, 'stock' => 9, 'min' => 4],
            ['cat' => 6, 'sku' => 'PRD-016', 'name' => 'Printer Barcode Thermal Zebra ZD220', 'buy' => 2100000, 'sell' => 2550000, 'stock' => 1, 'min' => 3], // Low stock
            ['cat' => 7, 'sku' => 'PRD-017', 'name' => 'Kamera CCTV Hikvision IP Dome 4MP', 'buy' => 580000, 'sell' => 750000, 'stock' => 18, 'min' => 6],
            ['cat' => 7, 'sku' => 'PRD-018', 'name' => 'NVR Hikvision 8 Channel DS-7608NI', 'buy' => 1650000, 'sell' => 2100000, 'stock' => 5, 'min' => 3],
            ['cat' => 8, 'sku' => 'PRD-019', 'name' => 'Speakerphone Meeting Jabra Speak 510', 'buy' => 2100000, 'sell' => 2600000, 'stock' => 6, 'min' => 3],
            ['cat' => 9, 'sku' => 'PRD-020', 'name' => 'UPS APC Back-UPS 1200VA 650W BX1200MI', 'buy' => 1850000, 'sell' => 2300000, 'stock' => 10, 'min' => 4],
            ['cat' => 10, 'sku' => 'PRD-021', 'name' => 'Kertas PaperOne A4 80gr 1 Rim', 'buy' => 45000, 'sell' => 58000, 'stock' => 50, 'min' => 15],
            ['cat' => 11, 'sku' => 'PRD-022', 'name' => 'Kursi Ergonomis Kantor Pira Metropolis', 'buy' => 850000, 'sell' => 1150000, 'stock' => 8, 'min' => 3],
            ['cat' => 12, 'sku' => 'PRD-023', 'name' => 'Tang Crimping RJ45 AMP Tyco Original', 'buy' => 280000, 'sell' => 375000, 'stock' => 11, 'min' => 4],
            ['cat' => 13, 'sku' => 'PRD-024', 'name' => 'SSD Samsung 980 Pro NVMe 1TB Gen4', 'buy' => 1450000, 'sell' => 1800000, 'stock' => 15, 'min' => 5],
            ['cat' => 14, 'sku' => 'PRD-025', 'name' => 'Bubble Wrap Hitam Roll 1.25 x 50 Meter', 'buy' => 110000, 'sell' => 150000, 'stock' => 0, 'min' => 3], // Out of stock
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

        // 5. Seed Historical Stock Mutations (20 Initial Records)
        $adminUser = User::where('role', 'admin')->first();
        $staffUser = User::where('role', 'staff')->first();

        $mutationsSample = [
            ['prod' => 0, 'sup' => 0, 'type' => 'in', 'qty' => 15, 'note' => 'Restock pengadaan awal laptop kantor'],
            ['prod' => 0, 'sup' => null, 'type' => 'out', 'qty' => 3, 'note' => 'Penyerahan laptop untuk dev team baru'],
            ['prod' => 2, 'sup' => 1, 'type' => 'in', 'qty' => 25, 'note' => 'Pengadaan monitor kantor cabang'],
            ['prod' => 2, 'sup' => null, 'type' => 'out', 'qty' => 5, 'note' => 'Pemasangan display workstation lantai 2'],
            ['prod' => 4, 'sup' => 3, 'type' => 'in', 'qty' => 7, 'note' => 'PO Switch Cisco rack server'],
            ['prod' => 4, 'sup' => null, 'type' => 'out', 'qty' => 2, 'note' => 'Instalasi switch ruang server'],
            ['prod' => 6, 'sup' => 4, 'type' => 'in', 'qty' => 16, 'note' => 'Restock AP UniFi dari distributor'],
            ['prod' => 6, 'sup' => null, 'type' => 'out', 'qty' => 2, 'note' => 'Pemasangan wifi ruang meeting'],
            ['prod' => 9, 'sup' => 2, 'type' => 'in', 'qty' => 30, 'note' => 'Pengadaan keyboard karyawan'],
            ['prod' => 9, 'sup' => null, 'type' => 'out', 'qty' => 5, 'note' => 'Penggantian keyboard divisi support'],
            ['prod' => 10, 'sup' => 2, 'type' => 'in', 'qty' => 50, 'note' => 'Restock mouse wireless Logitech'],
            ['prod' => 10, 'sup' => null, 'type' => 'out', 'qty' => 10, 'note' => 'Distribusi mouse divisi operasional'],
            ['prod' => 12, 'sup' => 0, 'type' => 'in', 'qty' => 8, 'note' => 'Restock kabel Belden Cat6'],
            ['prod' => 12, 'sup' => null, 'type' => 'out', 'qty' => 2, 'note' => 'Penarikan kabel jaringan ruang direksi'],
            ['prod' => 14, 'sup' => 5, 'type' => 'in', 'qty' => 12, 'note' => 'Pengadaan printer Epson all in one'],
            ['prod' => 14, 'sup' => null, 'type' => 'out', 'qty' => 3, 'note' => 'Penempatan printer divisi finance & HR'],
            ['prod' => 19, 'sup' => 6, 'type' => 'in', 'qty' => 12, 'note' => 'Restock unit UPS APC'],
            ['prod' => 19, 'sup' => null, 'type' => 'out', 'qty' => 2, 'note' => 'Pemasangan backup daya server lokal'],
            ['prod' => 23, 'sup' => 7, 'type' => 'in', 'qty' => 20, 'note' => 'Restock SSD Samsung 980 Pro 1TB'],
            ['prod' => 23, 'sup' => null, 'type' => 'out', 'qty' => 5, 'note' => 'Upgrade storage PC engineer'],
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

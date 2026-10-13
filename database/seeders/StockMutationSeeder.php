<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockMutation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockMutationSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::orderBy('id')->get();
        $suppliers = Supplier::orderBy('id')->get();
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

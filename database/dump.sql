-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2026 at 09:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sembako & Bahan Pokok', 'Beras, minyak goreng, gula, tepung, dan kebutuhan pokok', '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(2, 'Minuman & Kopi', 'Kopi, teh, susu kemasan, dan aneka minuman konsumsi', '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(3, 'Makanan Ringan & Biskuit', 'Camilan, biskuit, keripik, dan aneka snack', '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(4, 'Perlengkapan Mandi & Cuci', 'Sabun, sampo, pasta gigi, dan deterjen pembersih', '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(5, 'Alat Tulis Kantor (ATK)', 'Kertas HVS, pulpen, spidol, dan perlengkapan arsip', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(6, 'Pakaian & Tekstil', 'Kaos polos, kemeja kerja, handuk, dan pakaian katun', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(7, 'Alat Dapur & Memasak', 'Wajan anti lengket, panci stainless, dan perlengkapan masak', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(8, 'Perabotan Rumah Tangga', 'Sapu, ember plastik, lap kanebo, dan kebersihan rumah', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_12_133658_create_categories_table', 1),
(5, '2026_10_12_133659_create_suppliers_table', 1),
(6, '2026_10_12_133700_create_products_table', 1),
(7, '2026_10_12_133701_create_stock_mutations_table', 1),
(8, '2026_10_13_114000_add_soft_deletes_to_all_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `selling_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `min_stock` int NOT NULL DEFAULT '5',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sku`, `name`, `purchase_price`, `selling_price`, `stock`, `min_stock`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'PRD-001', 'Beras Pandan Wangi Premium 5kg', 68000.00, 78000.00, 35, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(2, 1, 'PRD-002', 'Minyak Goreng Sawit Pouch 2 Liter', 32000.00, 37500.00, 50, 15, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(3, 1, 'PRD-003', 'Gula Pasir Kristal Putih 1kg', 14500.00, 17000.00, 40, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(4, 1, 'PRD-004', 'Tepung Terigu Serbaguna 1kg', 11000.00, 13500.00, 25, 8, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(5, 2, 'PRD-005', 'Kopi Arabika Bubuk Murni 250gr', 35000.00, 45000.00, 20, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(6, 2, 'PRD-006', 'Teh Celup Hitam Melati Isi 25', 6500.00, 8500.00, 4, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(7, 2, 'PRD-007', 'Susu Sapi UHT Full Cream 1 Liter', 17500.00, 21000.00, 30, 8, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(8, 2, 'PRD-008', 'Air Mineral Galon 19 Liter', 19000.00, 23000.00, 15, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(9, 3, 'PRD-009', 'Biskuit Cokelat Kaleng 300gr', 28000.00, 35000.00, 18, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(10, 3, 'PRD-010', 'Keripik Singkong Renyah Balado 200gr', 12000.00, 16000.00, 22, 6, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(11, 3, 'PRD-011', 'Wafer Krim Cokelat Roll 150gr', 8500.00, 11500.00, 0, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(12, 4, 'PRD-012', 'Sabun Mandi Cair Botol 450ml', 18000.00, 23000.00, 28, 8, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(13, 4, 'PRD-013', 'Shampo Rambut Sehat 340ml', 27000.00, 34000.00, 16, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(14, 4, 'PRD-014', 'Deterjen Bubuk Bersih Harum 800gr', 19500.00, 24500.00, 35, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(15, 4, 'PRD-015', 'Pasta Gigi Herbal Perlindungan 190gr', 12500.00, 16000.00, 3, 8, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(16, 5, 'PRD-016', 'Kertas HVS Putih A4 80gr 1 Rim', 45000.00, 55000.00, 40, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(17, 5, 'PRD-017', 'Pulpen Gel Tinta Hitam 0.5mm 1 Lusin', 24000.00, 32000.00, 25, 6, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(18, 5, 'PRD-018', 'Spidol Papan Tulis Hitam 1 Kotak', 65000.00, 82000.00, 12, 4, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(19, 5, 'PRD-019', 'Map Arsip Dokumen Plastik 1 Lusin', 28000.00, 38000.00, 50, 15, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(20, 6, 'PRD-020', 'Kaos Polos Katun Combed 30s Hitam', 38000.00, 55000.00, 30, 10, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(21, 6, 'PRD-021', 'Kemeja Polos Formal Putih Lengan Panjang', 85000.00, 120000.00, 14, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(22, 6, 'PRD-022', 'Handuk Mandi Katun Lembut 70x140cm', 45000.00, 65000.00, 18, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(23, 7, 'PRD-023', 'Wajan Teflon Anti Lengket 24cm', 75000.00, 105000.00, 9, 3, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(24, 7, 'PRD-024', 'Panci Masak Stainless Steel 20cm', 68000.00, 95000.00, 11, 4, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18'),
(25, 8, 'PRD-025', 'Sapu Lantai Nilon Gagang Besi', 22000.00, 30000.00, 20, 5, NULL, '2026-10-13 09:15:18', '2026-10-13 09:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_mutations`
--

CREATE TABLE `stock_mutations` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `stock_before` int NOT NULL,
  `stock_after` int NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_mutations`
--

INSERT INTO `stock_mutations` (`id`, `product_id`, `user_id`, `supplier_id`, `type`, `quantity`, `stock_before`, `stock_after`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 1, 'in', 50, 35, 85, 'Penerimaan pasokan beras dari PT Sumber Pangan Nusantara', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(2, 1, 13, NULL, 'out', 15, 35, 20, 'Pengiriman beras pesanan toko cabang', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(3, 2, 2, 1, 'in', 60, 50, 110, 'Restock minyak goreng 2L dari distributor', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(4, 2, 13, NULL, 'out', 10, 50, 40, 'Penjualan grosir minyak goreng', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(5, 3, 2, 1, 'in', 50, 40, 90, 'Penerimaan gula pasir kristal putih', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(6, 3, 13, NULL, 'out', 10, 40, 30, 'Distribusi gula pasir ke display penjualan', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(7, 5, 2, 2, 'in', 30, 20, 50, 'Pengadaan kopi bubuk Arabika dari CV Berkah Makmur', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(8, 5, 13, NULL, 'out', 10, 20, 10, 'Pengambilan sampel dan penjualan outlet', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(9, 7, 2, 2, 'in', 40, 30, 70, 'Restock susu UHT Full Cream 1L', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(10, 7, 13, NULL, 'out', 10, 30, 20, 'Distribusi susu kemasan ke rak toko', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(11, 9, 2, 2, 'in', 25, 18, 43, 'Penerimaan biskuit cokelat kaleng', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(12, 9, 13, NULL, 'out', 7, 18, 11, 'Penjualan paket parsel biskuit', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(13, 12, 2, 3, 'in', 40, 28, 68, 'Restock sabun mandi cair dari PT Sinar Terang', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(14, 12, 13, NULL, 'out', 12, 28, 16, 'Penjualan retail sabun mandi', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(15, 14, 2, 3, 'in', 50, 35, 85, 'Penerimaan deterjen bubuk konsentrat', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(16, 14, 13, NULL, 'out', 15, 35, 20, 'Distribusi deterjen ke etalase', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(17, 16, 2, 4, 'in', 50, 40, 90, 'Pengadaan kertas HVS A4 dari CV Mitra Jaya', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(18, 16, 13, NULL, 'out', 10, 40, 30, 'Pemakaian operasional kantor dan cetak laporan', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(19, 20, 2, 5, 'in', 40, 30, 70, 'Penerimaan kaos polos katun hitam dari PT Sejahtera Tekstil', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(20, 20, 13, NULL, 'out', 10, 30, 20, 'Penjualan kaos katun ke customer retail', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PT Sumber Pangan Nusantara', '021-5566778', 'sales@sumberpangan.co.id', 'Kawasan Industri Pulogadung Blok A5, Jakarta Timur', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(2, 'CV Berkah Makmur Abadi', '031-8971234', 'distribusi@berkahmakmur.com', 'Jl. Rungkut Industri No. 42, Surabaya', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(3, 'PT Sinar Terang Distribusi', '021-6543210', 'order@sinarterang.co.id', 'Komplek Pergudangan Daan Mogot KM 12, Jakarta Barat', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(4, 'CV Mitra Jaya Stationery', '022-7201987', 'mitrajaya.atk@gmail.com', 'Jl. Soekarno Hatta No. 128, Bandung', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(5, 'PT Sejahtera Tekstil Pratama', '0274-889900', 'tekstil@sejahtera.co.id', 'Jl. Ring Road Utara Kav. 8, Sleman, Yogyakarta', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(6, 'Toko Grosir Sembako Rejeki', '024-7654321', 'grosir.rejeki@yahoo.com', 'Pasar Induk Johar Blok C No. 15, Semarang', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(7, 'PT Indah Cipta Mandiri', '021-8899776', 'houseware@indahcipta.com', 'Kawasan Pergudangan Harapan Indah Blok B, Bekasi', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(8, 'CV Harapan Sentosa Jaya', '031-5432190', 'harapansentosa@gmail.com', 'Jl. Margomulyo Indah Blok D-11, Surabaya', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(9, 'CV Pelita Surya Perkasa', '061-4561234', 'pelitasurya@medan.co.id', 'Jl. Krakatau Raya No. 90, Medan', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL),
(10, 'PT Aneka Niaga Lestari', '021-3456789', 'info@anekanikaga.id', 'Jl. Gatot Subroto Kav. 55, Jakarta Selatan', '2026-10-13 09:15:18', '2026-10-13 09:15:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Administrator', 'superadmin@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'superadmin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(2, 'Admin Utama', 'admin@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(3, 'Budi Santoso', 'admin.budi.santoso1@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(4, 'Siti Rahmawati', 'admin.siti.rahmawati2@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(5, 'Agus Prasetyo', 'admin.agus.prasetyo3@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(6, 'Dewi Lestari', 'admin.dewi.lestari4@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(7, 'Eko Wibowo', 'admin.eko.wibowo5@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(8, 'Rina Wijaya', 'admin.rina.wijaya6@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(9, 'Fajar Ramadhan', 'admin.fajar.ramadhan7@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(10, 'Nurul Hidayah', 'admin.nurul.hidayah8@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(11, 'Bambang Irawan', 'admin.bambang.irawan9@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(12, 'Dian Anggraini', 'admin.dian.anggraini10@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'admin', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(13, 'Staff Gudang Utama', 'staff@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(14, 'Adi Nugroho', 'staff.adi.nugroho1@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(15, 'Rizky Pratama', 'staff.rizky.pratama2@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(16, 'Indah Permata', 'staff.indah.permata3@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(17, 'Wahyu Hidayat', 'staff.wahyu.hidayat4@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(18, 'Bayu Saputra', 'staff.bayu.saputra5@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(19, 'Putri Ayu', 'staff.putri.ayu6@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(20, 'Dimas Wicaksono', 'staff.dimas.wicaksono7@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(21, 'Anisa Fitri', 'staff.anisa.fitri8@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(22, 'Yusuf Maulana', 'staff.yusuf.maulana9@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL),
(23, 'Lestari Handayani', 'staff.lestari.handayani10@demo.com', NULL, '$2y$12$fyTmrTSwm8mZ04hABw7xbOOspA4TG6JR9VC5DHe6L00Ou262ikOWK', 'staff', NULL, '2026-10-13 09:15:17', '2026-10-13 09:15:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_mutations_product_id_foreign` (`product_id`),
  ADD KEY `stock_mutations_user_id_foreign` (`user_id`),
  ADD KEY `stock_mutations_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  ADD CONSTRAINT `stock_mutations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `stock_mutations_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_mutations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

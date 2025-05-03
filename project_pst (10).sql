-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Apr 2025 pada 08.45
-- Versi server: 8.0.41-0ubuntu0.22.04.1
-- Versi PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pst`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggarans`
--

CREATE TABLE `anggarans` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodatas`
--

CREATE TABLE `biodatas` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabangs`
--

CREATE TABLE `cabangs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cabangs`
--

INSERT INTO `cabangs` (`id`, `nama_cabang`, `kode_cabang`, `alamat_cabang`, `created_at`, `updated_at`) VALUES
(1, 'PT Elyon Alfa Omega', 'HO', 'Jl. Raya Batujajar No.201, Giriasih, Kec. Batujajar, Kabupaten Bandung Barat, Jawa Barat 40561', '2025-03-08 02:04:03', '2025-03-12 04:09:48'),
(2, 'PT Adonai Alfa Omega', 'PDL', 'Jl. Raya Batujajar No.201, Giriasih, Kec. Batujajar, Kabupaten Bandung Barat, Jawa Barat 40561', '2025-03-10 01:10:45', '2025-03-12 04:09:40'),
(3, 'PT Natar Gerbang Angkasa', 'LPG', 'jl raya lampung', '2025-03-10 01:11:04', '2025-03-12 04:08:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang_tujuans`
--

CREATE TABLE `cabang_tujuans` (
  `id` bigint UNSIGNED NOT NULL,
  `ct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemens`
--

CREATE TABLE `departemens` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departemens`
--

INSERT INTO `departemens` (`id`, `nama_departemen`, `kode_departemen`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 'HRD', 'HRD', '-', '2025-03-08 03:46:23', '2025-03-08 03:46:23'),
(3, 'QCT', 'QCT', '-', '2025-03-10 01:34:48', '2025-03-10 01:34:48'),
(4, 'ACC', 'ACC', '-', '2025-03-10 01:35:12', '2025-03-10 01:35:12'),
(5, 'ENG', 'ENG', '-', '2025-03-10 01:35:31', '2025-03-10 01:35:31'),
(6, 'FIN', 'FIN', '-', '2025-03-10 01:35:38', '2025-03-10 01:35:38'),
(7, 'GPJ', 'GPJ', '-', '2025-03-10 01:35:51', '2025-03-10 01:35:51'),
(8, 'KND', 'KND', '-', '2025-03-10 01:36:04', '2025-03-10 01:36:04'),
(9, 'MKT', 'MKT', '-', '2025-03-10 01:36:13', '2025-03-10 01:36:13'),
(10, 'PBL', 'PBL', '-', '2025-03-10 01:36:22', '2025-03-10 01:36:22'),
(11, 'PE', 'PE', '-', '2025-03-10 01:36:28', '2025-03-10 01:36:28'),
(12, 'QC', 'QC', '-', '2025-03-10 01:36:37', '2025-03-10 01:36:37'),
(13, 'SIS', 'SIS', '-', '2025-03-10 01:36:44', '2025-03-10 01:36:44'),
(14, 'TAX', 'TAX', '-', '2025-03-10 01:36:52', '2025-03-10 01:36:52'),
(15, 'Branch Manager', 'BM', '-', '2025-03-10 03:58:40', '2025-03-10 03:58:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `no_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yang_menugaskan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_asal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_bm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acc_hrd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acc_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acc_ho` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acc_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status_koordinasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_keberangkatan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `submitted_by_bm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by_hrd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by_nm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by_ho` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by_cabang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_bm` text COLLATE utf8mb4_unicode_ci,
  `reason_ho` text COLLATE utf8mb4_unicode_ci,
  `reason_cabang` text COLLATE utf8mb4_unicode_ci,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `forms`
--

INSERT INTO `forms` (`id`, `no_surat`, `nama_pemohon`, `yang_menugaskan`, `cabang_asal`, `cabang_tujuan`, `tujuan`, `acc_bm`, `acc_hrd`, `acc_nm`, `acc_ho`, `acc_cabang`, `status_koordinasi`, `tanggal_keberangkatan`, `created_at`, `updated_at`, `submitted_by_bm`, `submitted_by_hrd`, `submitted_by_nm`, `submitted_by_ho`, `submitted_by_cabang`, `reason_bm`, `reason_ho`, `reason_cabang`, `cancel_reason`) VALUES
(2, '001/PST/PDL/III/2025', 'Johnny jhon', 'Prabu siliwangi', 'PDL', 'LPG', 'Study Banding', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-03-12', '2025-03-12 03:03:24', '2025-03-12 03:03:24', NULL, 'Johnny jhon', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '002/PST/PDL/III/2025', 'Johnny jhon', 'Prabu siliwangi', 'PDL', 'LPG', 'Melakukan Kunjungan Cabang', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-03-12', '2025-03-12 03:04:24', '2025-03-12 03:04:24', NULL, 'Johnny jhon', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '003/PST/PDL/III/2025', 'Johnny jhon', 'Prabu siliwangi', 'PDL', 'PT Natar Gerbang Angkasa', 'Melakukan Kunjungan Cabang', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-03-12', '2025-03-12 04:58:40', '2025-03-12 04:58:40', NULL, 'Johnny jhon', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '004/PST/PDL/III/2025', 'Johnny jhontor', 'Prabu siliwangi', 'PDL', 'PT Natar Gerbang Angkasa', 'Melakukan Survey Bangunan', 'oke', 'oke', '', 'oke', 'oke', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-03-15', '2025-03-15 02:29:11', '2025-03-18 03:33:11', 'Muhammad', 'Johnny jhon', NULL, 'sultan jamawi', 'prabu jhon', NULL, NULL, NULL, NULL),
(6, '001/PST/HO/IV/2025', 'sultan jamawi', 'Prabu siliwangi', 'HO', 'PT Natar Gerbang Angkasa', 'Perbantuan Penanganan Masalah HRD', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-04-24', '2025-04-24 01:51:39', '2025-04-24 01:51:39', NULL, 'sultan jamawi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '002/PST/HO/IV/2025', 'sultan jamawi', 'Prabu siliwangi', 'HO', 'PT Natar Gerbang Angkasa', 'Implementasi ERP', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-04-28', '2025-04-24 07:21:36', '2025-04-24 07:21:36', NULL, 'sultan jamawi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '003/PST/HO/IV/2025', 'sultan jamawi', 'Prabu john', 'HO', 'PT Adonai Alfa Omega', 'Perbantuan di Departemen GPJ', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-04-26', '2025-04-26 01:40:51', '2025-04-26 01:40:52', NULL, 'sultan jamawi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '004/PST/HO/IV/2025', 'sultan jamawi', 'Prabu john', 'HO', 'PT Adonai Alfa Omega', 'Perbantuan di Departemen GPJ', '', 'oke', '', '', '', 'sudah melakukan koordinasi antara bm, hrd ho dan cabang', '2025-04-26', '2025-04-26 06:29:49', '2025-04-26 06:29:49', NULL, 'sultan jamawi', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `maskapais`
--

CREATE TABLE `maskapais` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_maskapai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_maskapai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `maskapais`
--

INSERT INTO `maskapais` (`id`, `kode_maskapai`, `nama_maskapai`, `jenis_kendaraan`, `created_at`, `updated_at`) VALUES
(4, '001 - A', 'GARUDA AIR', 'Bus', '2025-04-15 07:45:08', '2025-04-15 07:45:08'),
(5, '002 - A', 'BLUE BIRD', 'Mobil', '2025-04-15 08:05:35', '2025-04-15 08:05:35'),
(6, '003 - A', 'KERAMAT JATI', 'Bus', '2025-04-15 08:06:30', '2025-04-15 08:06:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_19_023440_create_departemen_table', 1),
(6, '2024_12_19_035249_create_cabangs_table', 1),
(7, '2024_12_19_043329_create_tujuans_table', 1),
(9, '2024_12_23_065444_create_nama_pegawais_table', 1),
(10, '2024_12_24_013129_add_role_to_users_table', 2),
(11, '2024_12_25_023340_create_biodatas_table', 2),
(12, '2025_01_08_012138_add_nik_departemen_cabangasal_nohp_to_users_table', 2),
(13, '2025_01_08_063620_add_status_to_forms_table', 2),
(14, '2025_01_21_083754_add_nama_lengkap_to_users_table', 2),
(15, '2025_02_04_012604_add_role_to_users_table', 2),
(18, '2025_03_08_015558_modify_role_id_nullable', 3),
(22, '2024_12_19_084605_create_forms_table', 4),
(23, '2025_02_17_075658_add_submitted_by_to_forms_table', 4),
(24, '2025_03_01_015553_add_reason_to_forms_table', 4),
(27, '2025_03_25_020227_create_transports_table', 6),
(29, '2025_04_05_061840_create_anggarans_table', 6),
(30, '2025_03_25_020236_create_maskapais_table', 7),
(34, '2025_03_24_011722_create_ticketings_table', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nama_pegawais`
--

CREATE TABLE `nama_pegawais` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `nama_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tanggal_berangkat` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `acc_nm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nama_pegawais`
--

INSERT INTO `nama_pegawais` (`id`, `form_id`, `nama_pegawai`, `departemen`, `nik`, `upload_file`, `tanggal_berangkat`, `tanggal_kembali`, `acc_nm`, `alasan`, `created_at`, `updated_at`) VALUES
(5, 2, 'Joko Anwar', 'ENG', '111111111132222', 'uploads/1pg3b2.jpg', '2025-03-12', '2025-03-26', '', '', '2025-03-12 03:03:24', '2025-03-12 03:03:24'),
(6, 2, 'Alfi Sentana', 'KND', '2222222222211', 'uploads/1pg3b2.jpg', '2025-03-12', '2025-03-26', '', '', '2025-03-12 03:03:24', '2025-03-12 03:03:24'),
(7, 3, 'Joko Anwar', 'ENG', '111111111132222', 'uploads/1pg3b2.jpg', '2025-03-12', '2025-03-19', '', '', '2025-03-12 03:04:24', '2025-03-12 03:04:24'),
(8, 4, 'Johnny jhon', 'HRD', '22222222222223', 'uploads/1pg3b2.jpg', '2025-03-12', '2025-03-19', '', '', '2025-03-12 04:58:40', '2025-03-12 04:58:40'),
(9, 5, 'Alfi Sentana', 'KND', '2222222222211', 'uploads/1pg3b2.jpg', '2025-03-15', '2025-03-20', 'oke', 'Diterima', '2025-03-15 02:29:12', '2025-03-18 03:31:34'),
(10, 6, 'sultan jamawi', 'HRD', '11111111111111', 'uploads/1pg3b2.jpg', '2025-04-24', '2025-04-30', '', '', '2025-04-24 01:51:39', '2025-04-24 01:51:39'),
(11, 7, 'sultan jamawi', 'HRD', '11111111111111', 'uploads/1pg3b2.jpg', '2025-04-29', '2025-05-09', '', '', '2025-04-24 07:21:36', '2025-04-24 07:21:36'),
(12, 9, 'sultan jamawi', 'HRD', '11111111111111', 'uploads/1pg3b2.jpg', '2025-04-26', '2025-04-30', '', '', '2025-04-26 01:40:52', '2025-04-26 01:40:52'),
(13, 10, 'sultan jamawi', 'HRD', '11111111111111', 'uploads/1pg3b2.jpg', '2025-04-26', '2025-04-30', '', '', '2025-04-26 06:29:49', '2025-04-26 06:29:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ticketings`
--

CREATE TABLE `ticketings` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `no_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_By` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `issued` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `maskapai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `transport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `beban_biaya` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `keberangkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nominal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rute` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rute_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tiket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ticketings`
--

INSERT INTO `ticketings` (`id`, `form_id`, `no_surat`, `nama_pemohon`, `assigned_By`, `hp`, `pegawai`, `lampiran`, `issued`, `maskapai`, `invoice`, `transport`, `beban_biaya`, `keberangkatan`, `nominal`, `waktu`, `rute`, `rute_tujuan`, `tiket`, `created_at`, `updated_at`) VALUES
(1, 10, '004/PST/HO/IV/2025', 'sultan jamawi', 'Prabu john', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-04-26 06:29:49', '2025-04-26 06:29:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transports`
--

CREATE TABLE `transports` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tujuans`
--

CREATE TABLE `tujuans` (
  `id` bigint UNSIGNED NOT NULL,
  `tujuan_penugasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tujuans`
--

INSERT INTO `tujuans` (`id`, `tujuan_penugasan`, `created_at`, `updated_at`) VALUES
(1, 'Perbantuan Penanganan Masalah HRD', '2025-03-10 01:21:05', '2025-03-10 01:21:05'),
(2, 'Meeting dengan NM dan Direksi', '2025-03-10 01:21:10', '2025-03-10 01:21:10'),
(3, 'Melakukan Kunjungan Cabang', '2025-03-10 01:21:18', '2025-03-10 01:21:18'),
(4, 'Study Banding', '2025-03-10 01:21:58', '2025-03-10 01:21:58'),
(5, 'Melakukan Survey Bangunan', '2025-03-10 01:22:08', '2025-03-10 01:22:08'),
(6, 'Perbantuan Penanganan Masalah Pajak', '2025-03-10 01:22:34', '2025-03-10 01:22:34'),
(7, 'Perbantuan Penanganan Masalah Kendaraan', '2025-03-10 01:22:52', '2025-03-10 01:22:52'),
(8, 'Belajar Mesin suntik dan Video jet', '2025-03-10 01:22:59', '2025-03-10 01:22:59'),
(9, 'Perbantuan Penanganan Masalah Kualitas Produk', '2025-03-10 01:23:19', '2025-03-10 01:23:19'),
(10, 'Perbantuan Penanganan Masalah Babon', '2025-03-10 01:23:31', '2025-03-10 01:23:31'),
(11, 'Kunjungan Cabang dan Perbantuan Persiapan Produk Baru Steam Cake', '2025-03-10 01:23:40', '2025-03-10 01:23:40'),
(12, 'Mengikuti Pelatihan di Dinas Lingkungan Hidup', '2025-03-10 01:23:52', '2025-03-10 01:23:52'),
(13, 'Mengikuti Pelatihan di Departemen Engineering', '2025-03-10 01:24:00', '2025-03-10 01:24:00'),
(14, 'Implementasi ERP', '2025-03-10 01:24:06', '2025-03-10 01:24:06'),
(15, 'Perbantuan di Departemen GPJ', '2025-03-10 01:24:16', '2025-03-10 01:24:16'),
(16, 'Perbantuan di Departemen Marketing', '2025-03-10 01:24:24', '2025-03-10 01:24:24'),
(17, 'Perbantuan Set Jalur dan Toko', '2025-03-10 01:24:32', '2025-03-10 01:24:32'),
(18, 'Perbantuan Penanganan Distribusi Produk', '2025-03-10 01:24:48', '2025-03-10 01:24:48'),
(19, 'Perbantuan Kekurangan Personil atau Rotasi', '2025-03-10 01:25:12', '2025-03-10 01:25:12'),
(20, 'Perbantuan Penanganan Masalah Limbah', '2025-03-10 01:25:39', '2025-03-10 01:25:39'),
(21, 'Mobilisasi di Departemen Produksi', '2025-03-10 01:25:45', '2025-03-10 01:25:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departemen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cabang_asal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `ttd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nik`, `departemen`, `cabang_asal`, `no_hp`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `ttd`, `remember_token`, `created_at`, `updated_at`, `role`, `nama_lengkap`) VALUES
(12, '2222233333333331', 'EDP', 'Head Office', '083821446003', 'alfi', 'alfi@yahoo.com', NULL, '$2y$12$MjdpMsRd8tPjvs8tUcTpk.sycY.6Z8kutxoizdqYAvK3Mk7/AJwsm', NULL, '1741401240_12.png', NULL, '2025-03-08 02:06:46', '2025-03-08 02:34:00', 'admin', 'Muhammad Alfi Sentana'),
(14, '11111111111111', 'HRD', 'HO', '083821440572', 'sultan', 'sultan@yahoo.com', NULL, '$2y$12$r1jSlftTlov/JzRJXSZecOvwmiKp2P7NXQ9k1o9x1rtZEs6pHhEDG', NULL, '1741585582_14.png', NULL, '2025-03-08 03:46:57', '2025-03-10 05:46:22', 'hrd', 'sultan jamawi'),
(15, '22222222222223', 'HRD', 'PDL', '083821440573', 'john', 'john@yahoo.com', NULL, '$2y$12$b4PiBdfFR0S9I63qGQMfmuNPDjqTj45sIysyjIePWxlKmQeYi/.hu', NULL, '', NULL, '2025-03-10 03:46:50', '2025-03-10 03:46:50', 'hrd', 'Johnny jhon'),
(16, '123123123123', 'Branch Manager', 'PDL', '0823212221132', 'muhammad', 'Muhammad@yahoo.com', NULL, '$2y$12$0UF3.XfqfEon54hroTBaGOrlKbR94ISOy1ozq7mKNw7mviWAtyqAW', NULL, '', NULL, '2025-03-10 03:59:36', '2025-03-10 03:59:36', 'bm', 'Muhammad'),
(18, '44444444444444', 'KND', 'PDL', '085466654212', 'jamal', 'jamal@yahoo.com', NULL, '$2y$12$3mcgqHTJYEueN13m9j.ox.FFv9jmn9uPb3gMkOaVhnJRRcOTGPqwi', NULL, '', NULL, '2025-03-11 01:59:16', '2025-03-11 01:59:16', 'nm', 'Jamaludin'),
(19, '44444444222222', 'ENG', 'PDL', '0838214405722', 'prabowo', 'prabowo@yahoo.com', NULL, '$2y$12$lAvvC8i8T8HXhlIFMJO88ODPkqe83m3Bscx1MVIifmkblidiKQk2G', NULL, '', NULL, '2025-03-11 02:34:30', '2025-03-11 02:34:30', 'nm', 'prabowo supriadi'),
(20, '111111111132222', 'ENG', 'PDL', '0838214460032', 'joko', 'joko@yahoo.com', NULL, '$2y$12$uoruwbNaT3H3bLq8xIhkgujmuK7OplQ9zoKfYz2hlqix/1C440NGW', NULL, '', NULL, '2025-03-11 02:38:07', '2025-03-11 02:38:07', 'pegawai', 'Joko Anwar'),
(21, '2222222222211', 'KND', 'PDL', '083821446003', 'alfi', 'alfi@gmail.com', NULL, '$2y$12$omXKr/COjUV.n2y6uGVZJuztodxTfziPhiMbNP58TRs0e3KJ4wRXi', NULL, '', NULL, '2025-03-11 02:46:51', '2025-03-11 02:46:51', 'pegawai', 'Alfi Sentana'),
(22, '12321111111111111111', 'SIS', 'PT Adonai Alfa Omega', '085466654212', 'indah', 'indah@yahoo.com', NULL, '$2y$12$e.qJa8raA7lppz9.6jJ1ruHnENNZTXJcWts81TD1/Tc6PjXhlA25S', NULL, '', NULL, '2025-03-12 07:26:38', '2025-03-12 07:26:38', 'pegawai', 'indah'),
(23, '5555555555551', 'Branch Manager', 'PT Natar Gerbang Angkasa', '0854666542122', 'prabu', 'prabu@yahoo.com', NULL, '$2y$12$2N0L6oh47zeAobDzN2qBVe0pw94z6uONZFZQP0zGmHrQ6Ck62KbU6', NULL, '', NULL, '2025-03-18 03:32:54', '2025-03-18 03:32:54', 'bm', 'prabu jhon');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggarans`
--
ALTER TABLE `anggarans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `biodatas`
--
ALTER TABLE `biodatas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cabangs`
--
ALTER TABLE `cabangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cabangs_kode_cabang_unique` (`kode_cabang`);

--
-- Indeks untuk tabel `cabang_tujuans`
--
ALTER TABLE `cabang_tujuans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `departemens`
--
ALTER TABLE `departemens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departemens_kode_departemen_unique` (`kode_departemen`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forms_no_surat_unique` (`no_surat`);

--
-- Indeks untuk tabel `maskapais`
--
ALTER TABLE `maskapais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maskapais_kode_maskapai_unique` (`kode_maskapai`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nama_pegawais`
--
ALTER TABLE `nama_pegawais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama_pegawais_form_id_foreign` (`form_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `ticketings`
--
ALTER TABLE `ticketings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticketings_no_surat_unique` (`no_surat`);

--
-- Indeks untuk tabel `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tujuans`
--
ALTER TABLE `tujuans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggarans`
--
ALTER TABLE `anggarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biodatas`
--
ALTER TABLE `biodatas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cabangs`
--
ALTER TABLE `cabangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cabang_tujuans`
--
ALTER TABLE `cabang_tujuans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `departemens`
--
ALTER TABLE `departemens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `maskapais`
--
ALTER TABLE `maskapais`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `nama_pegawais`
--
ALTER TABLE `nama_pegawais`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ticketings`
--
ALTER TABLE `ticketings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transports`
--
ALTER TABLE `transports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tujuans`
--
ALTER TABLE `tujuans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nama_pegawais`
--
ALTER TABLE `nama_pegawais`
  ADD CONSTRAINT `nama_pegawais_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

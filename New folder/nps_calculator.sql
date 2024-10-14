-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Oct 07, 2024 at 01:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nps_calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@idsil.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', NULL, '2024-10-01 04:19:19', '2024-10-01 04:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `idsGroup` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `name`, `email`, `organization`, `idsGroup`, `created_at`, `updated_at`) VALUES
(1, 8, 'Ella Leblanc', 'harshkumar41201@gmail.com', 'Maynard Beard LLC', 'Argus', '2024-10-02 02:33:17', '2024-10-02 02:33:17'),
(2, 8, 'Stone Sherman', 'maabaap2016@gmail.com', 'Smith Spencer LLC', 'SSB', '2024-10-02 02:41:54', '2024-10-02 02:41:54'),
(3, 10, 'Myra Fulton', 'harshkumar41201@gmail.com', 'Donaldson and Roberts Plc', 'Argus', '2024-10-03 00:35:31', '2024-10-03 00:35:31'),
(7, 11, 'Yoshio Howard', 'harshkumar41201@gmail.com', 'Meadows and Spencer Co', 'Argus', '2024-10-04 03:21:38', '2024-10-04 03:21:38'),
(8, 8, 'Sarah Schmidt', 'harshkumar41201@gmail.com', 'Hickman and Armstrong Traders', '3E', '2024-10-06 23:30:55', '2024-10-06 23:30:55'),
(9, 8, 'Dana Galloway', 'harshkumar41201@gmail.com', 'Lindsey Wall Associates', 'Argus', '2024-10-06 23:31:50', '2024-10-06 23:31:50'),
(10, 8, 'Garrett Figueroa', 'harshkumar41201@gmail.com', 'Herrera and James LLC', 'Argus', '2024-10-06 23:33:07', '2024-10-06 23:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ids_groups`
--

CREATE TABLE `ids_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ids_groups`
--

INSERT INTO `ids_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'SSB', '2024-10-01 04:19:55', '2024-10-01 04:19:55'),
(2, '3E', '2024-10-01 04:19:59', '2024-10-01 04:19:59'),
(3, 'Argus', '2024-10-01 04:20:04', '2024-10-01 04:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_00_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_15_045809_create_admins_table', 1),
(5, '2024_09_16_044418_create_clients_table', 1),
(6, '2024_09_17_101124_create_user_submissions_table', 1),
(7, '2024_09_17_102102_create_survey2_responses_table', 1),
(8, '2024_09_19_053725_create_ids_groups_table', 1),
(9, '2024_09_25_063928_create_survey_token_table', 1),
(10, '2024_10_01_094735_create_user_groups_table', 1),
(11, '2024_10_01_113518_create_sub_admin_table', 2),
(12, '2024_10_01_113518_create_sub_admins_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('E2muTR4sZW5OLBEMyJY4qyKduNWwOTE15g1HAAs0', 16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUmNjSjVidzFZSks3M0dzM1JETllabWZHejlHbEJKbkd0bzd2TW5TQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXJzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2O30=', 1728298907),
('OtVnxaHBKRX7FcoeJCcJ2Lp9oN1A4B3wHBqNRA92', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ2JCZkpEUWg4Tzg0Z3ZiVEwzYk9udHRMYVJvM1JQcU4zVVVydEFkWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9zdWJhZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1728286006),
('S1Dlm0VFbHGRGfsX8ycxgkTbeCfgXrxUtnqAsWIX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVnBzQnBRTkowTnNxc3ExODZCb2NSZVluenlkMFBORU9rdjZTOVllaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1728275333),
('wUwfuCNkTBxfFW0g8yymdcepxOSv6t3VkIQ0SBEw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQllYbnRTQktVdjhza0VsdGNKQ01TYkc4RFJwcUxCa3ROdHB3ZVNXdiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXJzLXN0YXR1cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9zdWJhZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1728056973);

-- --------------------------------------------------------

--
-- Table structure for table `sub_admins`
--

CREATE TABLE `sub_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idsGroup` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_admins`
--

INSERT INTO `sub_admins` (`id`, `name`, `email`, `idsGroup`, `password`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Sub Admin', 'subadmin@idsil.com', '[\"SSB\",\"Argus\"]', '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', NULL, NULL, '2024-10-06 23:29:12'),
(4, 'Conan Noel', 'suqe@mailinator.com', '[\"3E\"]', '$2y$12$xx0aIACwwvO/N2YF7tRFNO1DSsqNFt03ekbLjTc4jbYGmfulMpUMW', '2024-10-06 23:37:30', '2024-10-02 23:19:45', '2024-10-06 23:37:30'),
(5, 'Elvis Padilla', 'qywacysemu@mailinator.com', 'SSB', '$2y$12$TOK2lEBTaXlEdaOXQV1csOhxE6ri1xgax1UYbyqFlh8Af2faovJo.', '2024-10-06 23:37:33', '2024-10-03 00:14:31', '2024-10-06 23:37:33'),
(6, 'Curran Davis', 'ruhys@mailinator.com', '3E,Argus', '$2y$12$PmhLkUWXncXO6/QXcFUNZeQpFK0d24WC3D8Q/TuR7aw2Ef.Krcv4W', '2024-10-06 23:37:35', '2024-10-04 10:00:16', '2024-10-06 23:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `question_index` int(11) NOT NULL,
  `response` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_responses`
--

INSERT INTO `survey_responses` (`id`, `client_id`, `question_index`, `response`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '10', '2024-10-02 02:34:10', '2024-10-02 02:34:10'),
(2, 1, 2, '9', '2024-10-02 02:34:10', '2024-10-02 02:34:10'),
(3, 1, 3, 'Na', '2024-10-02 02:34:10', '2024-10-02 02:34:10'),
(4, 1, 4, '9', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(5, 1, 5, '8', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(6, 1, 6, 'Na', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(7, 1, 7, '6', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(8, 1, 8, '5', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(9, 1, 9, '9', '2024-10-02 02:34:11', '2024-10-02 02:34:11'),
(10, 2, 1, '10', '2024-10-02 02:43:06', '2024-10-02 02:43:06'),
(11, 2, 2, '8', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(12, 2, 3, '7', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(13, 2, 4, '5', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(14, 2, 5, '4', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(15, 2, 6, '1', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(16, 2, 7, '0', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(17, 2, 8, '10', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(18, 2, 9, '3', '2024-10-02 02:43:07', '2024-10-02 02:43:07'),
(19, 3, 1, '10', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(20, 3, 2, '9', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(21, 3, 3, 'Na', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(22, 3, 4, '7', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(23, 3, 5, '6', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(24, 3, 6, '5', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(25, 3, 7, '8', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(26, 3, 8, '9', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(27, 3, 9, 'Na', '2024-10-03 00:40:07', '2024-10-03 00:40:07'),
(28, 7, 1, '10', '2024-10-04 03:22:52', '2024-10-04 03:22:52'),
(29, 7, 2, '9', '2024-10-04 03:22:52', '2024-10-04 03:22:52'),
(30, 7, 3, '8', '2024-10-04 03:22:52', '2024-10-04 03:22:52'),
(31, 7, 4, '7', '2024-10-04 03:22:53', '2024-10-04 03:22:53'),
(32, 7, 5, 'Na', '2024-10-04 03:22:53', '2024-10-04 03:22:53'),
(33, 7, 6, '8', '2024-10-04 03:22:53', '2024-10-04 03:22:53'),
(34, 7, 7, '6', '2024-10-04 03:22:53', '2024-10-04 03:22:53'),
(35, 7, 8, '5', '2024-10-04 03:22:53', '2024-10-04 03:22:53'),
(36, 7, 9, '10', '2024-10-04 03:22:53', '2024-10-04 03:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `survey_token`
--

CREATE TABLE `survey_token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_submission_id` bigint(20) UNSIGNED NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_token`
--

INSERT INTO `survey_token` (`id`, `token`, `user_submission_id`, `used`, `created_at`, `updated_at`) VALUES
(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo4LCJjbGllbnRfaWQiOjEsInVzZXJfc3VibWlzc2lvbl9pZCI6MSwiZXhwIjoxNzI3OTQyNTk3fQ.S9SZBziRF6sdIK2nn7VkAF6VPH740RQznQI3-k5PcmM', 1, 1, '2024-10-02 02:33:17', '2024-10-02 02:34:11'),
(2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo4LCJjbGllbnRfaWQiOjIsInVzZXJfc3VibWlzc2lvbl9pZCI6MiwiZXhwIjoxNzI3OTQzMTE0fQ.PHaeHBwL_1PFiU1YVk5azoAAVFftNSU-BC1fc3LgzPY', 2, 1, '2024-10-02 02:41:54', '2024-10-02 02:43:08'),
(3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMCwiY2xpZW50X2lkIjozLCJ1c2VyX3N1Ym1pc3Npb25faWQiOjMsImV4cCI6MTcyODAyMTkzMn0.-ZTJY6Pr-qP2hujz7J39WtV0h_Pz5EDxjTUDaP1b-wo', 3, 1, '2024-10-03 00:35:32', '2024-10-03 00:40:08'),
(4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMSwiY2xpZW50X2lkIjo3LCJ1c2VyX3N1Ym1pc3Npb25faWQiOjQsImV4cCI6MTcyODExODI5OH0.4tnxPe1oC1Sd2Tkd758g3H5bxE7JGaFr-SJXDNt1R6Y', 4, 1, '2024-10-04 03:21:39', '2024-10-04 03:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `idsGroup` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `idsGroup`, `deleted_at`, `created_at`, `updated_at`) VALUES
(7, 'Rahim Humphrey', 'myzulys@mailinator.com', NULL, '$2y$12$WGPj5c0EQ.hpI4dAg7w26OXWpdeR5l3t0ZJHKPtJ7tIfrLF4srKyC', '3E,Argus', '2024-10-06 23:37:37', '2024-10-01 04:49:55', '2024-10-06 23:37:37'),
(8, 'Harsh Kumar', 'harsh.kumar@idsil.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\"SSB\",\"3E\"]', NULL, '2024-10-02 02:31:30', '2024-10-06 23:36:32'),
(9, 'Harsh', 'maabaap2016@gmail.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', 'SSB', '2024-10-06 23:37:42', '2024-10-02 23:17:59', '2024-10-06 23:37:42'),
(10, 'Naomi Harrington', 'sugikaqox@mailinator.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\"3E\"]', '2024-10-06 23:37:44', '2024-10-02 23:21:35', '2024-10-06 23:37:44'),
(11, 'Guy Whitley', 'gobeluj@mailinator.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\'3E\',\'Argus\']', '2024-10-06 23:37:46', '2024-10-04 01:05:20', '2024-10-06 23:37:46'),
(12, 'Kylan Jenkins', 'fejyri@mailinator.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\"All\"]', '2024-10-06 23:37:48', '2024-10-04 06:42:50', '2024-10-06 23:37:48'),
(13, 'Lacey Whitfield', 'wynyp@mailinator.com', NULL, '$2y$12$PtQlo9NyIaw3V57SgnS9u.H9nZZZBMD7pJLeg1U7tfjyd3cR4FDEG', '[\"3E\",\"Argus\"]', '2024-10-06 23:37:50', '2024-10-04 09:59:56', '2024-10-06 23:37:50'),
(14, 'Curran Davis', 'ruhys@mailinator.com', NULL, '$2y$12$A1DHxmODQClKqgg1RSEd2OCyu/DaYdq5UanmCtwZ3Z0i.48a2TWQ2', '[\'3E\',\'Argus\']', '2024-10-04 10:01:39', '2024-10-04 10:00:16', '2024-10-04 10:01:39'),
(15, 'Madonna Lamb', 'mejipupoqi@mailinator.com', NULL, '$2y$12$62xjZBC9WDCUipflf774HejqOW3suV/ZcA1tVkmmlwsOPhx3X0Wua', '[\'3E\']', '2024-10-04 10:01:36', '2024-10-04 10:00:29', '2024-10-04 10:01:36'),
(16, 'Admin', 'admin@idsil.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\'SSB\',\'3E\',\'Argus\']', NULL, '2024-10-06 23:38:28', '2024-10-06 23:38:28'),
(17, 'Subadmin', 'subadmin@idsil.com', NULL, '$2y$12$zVwFHVbxoUe5T3JAilyoBuvLnznMNM7AJt81A1yOlppq9QnWuXXwu', '[\'SSB\',\'3E\',\'Argus\']', NULL, '2024-10-06 23:39:18', '2024-10-06 23:39:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_submissions`
--

CREATE TABLE `user_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `idsGroup` varchar(255) NOT NULL,
  `projectName` varchar(255) NOT NULL,
  `csatOccurrence` varchar(255) NOT NULL,
  `idsLeadManager` varchar(255) NOT NULL,
  `clientOrganization` varchar(255) NOT NULL,
  `clientContactName` varchar(255) NOT NULL,
  `clientEmailAddress` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_submissions`
--

INSERT INTO `user_submissions` (`id`, `user_id`, `client_id`, `idsGroup`, `projectName`, `csatOccurrence`, `idsLeadManager`, `clientOrganization`, `clientContactName`, `clientEmailAddress`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'Argus', 'Kenneth Hogan', 'Quaterly', 'Sunt quibusdam eum o', 'Maynard Beard LLC', 'Ella Leblanc', 'harshkumar41201@gmail.com', 'done', '2024-10-02 02:33:17', '2024-10-02 02:34:11'),
(2, 8, 2, 'SSB', 'Giselle Hahn', 'Quaterly', 'Dicta accusantium iu', 'Smith Spencer LLC', 'Stone Sherman', 'maabaap2016@gmail.com', 'done', '2024-10-02 02:41:54', '2024-10-02 02:43:08'),
(3, 10, 3, 'Argus', 'Abel Bowman', 'Yearly', 'Vitae in sunt offici', 'Donaldson and Roberts Plc', 'Myra Fulton', 'harshkumar41201@gmail.com', 'done', '2024-10-03 00:35:32', '2024-10-03 00:40:08'),
(4, 11, 7, 'Argus', 'Martin Watkins', 'Yearly', 'Voluptatibus quos co', 'Meadows and Spencer Co', 'Yoshio Howard', 'harshkumar41201@gmail.com', 'done', '2024-10-04 03:21:38', '2024-10-04 03:22:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ids_groups`
--
ALTER TABLE `ids_groups`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_admins`
--
ALTER TABLE `sub_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_admins_email_unique` (`email`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_responses_client_id_foreign` (`client_id`);

--
-- Indexes for table `survey_token`
--
ALTER TABLE `survey_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `survey_token_token_unique` (`token`),
  ADD KEY `survey_token_user_submission_id_foreign` (`user_submission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_groups_user_id_foreign` (`user_id`),
  ADD KEY `user_groups_group_id_foreign` (`group_id`);

--
-- Indexes for table `user_submissions`
--
ALTER TABLE `user_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_submissions_client_id_unique` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ids_groups`
--
ALTER TABLE `ids_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sub_admins`
--
ALTER TABLE `sub_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `survey_token`
--
ALTER TABLE `survey_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_submissions`
--
ALTER TABLE `user_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD CONSTRAINT `survey_responses_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_token`
--
ALTER TABLE `survey_token`
  ADD CONSTRAINT `survey_token_user_submission_id_foreign` FOREIGN KEY (`user_submission_id`) REFERENCES `user_submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `ids_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_submissions`
--
ALTER TABLE `user_submissions`
  ADD CONSTRAINT `user_submissions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

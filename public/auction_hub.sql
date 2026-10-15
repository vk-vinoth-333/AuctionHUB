-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2026 at 09:00 AM
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
-- Database: `auction_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `forgot_unique_code` text DEFAULT NULL,
  `forgot_at` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `forgot_unique_code`, `forgot_at`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$C12bZZr1pux5wd.hcwy9A.qABs0FHiaHiAKSz0mUJcDw.tkLcTyBa', 'admin@gmail.com', '', '', 'panel/user.jpg', 1, '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(2, 'YBCC Vinoth', '$2y$10$9L9mj8QOQExS1a2Gb25hye/h79x3kM0y6ft4Ceo82u5EjivWLvlCS', 'kvbvinoth333@gmail.com', NULL, NULL, NULL, 1, '2026-03-05 07:55:53', '2026-03-05 07:55:53');

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
-- Table structure for table `featured_section_rss_feeds`
--

CREATE TABLE `featured_section_rss_feeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `featured_section_id` bigint(20) UNSIGNED NOT NULL,
  `rss_feed_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_27_064401_create_all_tables', 1),
(6, '2024_04_10_104520_create_admin_table', 1),
(7, '2024_04_10_104525_create_tbl_users_table', 1),
(8, '2024_04_10_104530_create_tbl_languages_table', 1),
(9, '2024_04_10_105710_create_tbl_category_table', 1),
(10, '2024_04_10_110701_create_tbl_subcategory_table', 1),
(11, '2024_04_10_114540_create_tbl_tag_table', 1),
(12, '2024_04_10_115137_create_tbl_news_table', 1),
(13, '2024_04_10_115178_create_tbl_news_image_table', 1),
(14, '2024_04_10_120536_create_tbl_breaking_news_table', 1),
(15, '2024_04_10_122518_create_tbl_live_streaming_table', 1),
(16, '2024_04_12_091014_create_tbl_settings_table', 1),
(17, '2024_04_12_091153_create_tbl_bookmark_table', 1),
(18, '2024_04_12_091423_create_tbl_news_like_table', 1),
(19, '2024_04_12_091725_create_tbl_news_view_table', 1),
(20, '2024_04_12_092110_create_tbl_breaking_news_view_table', 1),
(21, '2024_04_12_092330_create_tbl_comment_table', 1),
(22, '2024_04_12_093239_create_tbl_comment_flag_table', 1),
(23, '2024_04_12_095441_create_tbl_comment_like_table', 1),
(24, '2024_04_12_100023_create_tbl_comment_notification_table', 1),
(25, '2024_04_12_100436_create_tbl_survey_question_table', 1),
(26, '2024_04_12_100901_create_tbl_survey_option_table', 1),
(27, '2024_04_12_102723_create_tbl_survey_result_table', 1),
(28, '2024_04_12_103031_create_tbl_location_table', 1),
(29, '2024_04_12_103211_create_tbl_notifications_table', 1),
(30, '2024_04_13_052620_create_tbl_token_table', 1),
(31, '2024_04_13_052717_create_tbl_users_category_table', 1),
(32, '2024_04_13_053529_create_tbl_pages_table', 1),
(33, '2024_04_13_054156_create_tbl_featured_sections_table', 1),
(34, '2024_04_13_055248_create_tbl_ad_spaces_table', 1),
(35, '2024_04_13_055535_create_tbl_web_settings_table', 1),
(36, '2024_04_13_055705_create_tbl_web_seo_pages_table', 1),
(37, '2024_07_15_161407_create_tbl_social_media_table', 1),
(38, '2024_11_09_150136_create_tbl_rss_table', 1),
(39, '2025_01_23_100907_version_3_2_0', 1),
(40, '2025_04_07_051450_version_3_2_1', 1),
(41, '2025_05_06_102624_version_3_2_2', 1),
(42, '2025_05_06_102624_version_3_2_3', 1),
(43, '2025_08_18_183935_version_3_2_4', 1),
(44, '2025_09_03_124942_update_tbl_news_table', 1),
(45, '2025_11_08_155756_version_3_2_5', 1),
(46, '2025_12_19_095852_version_3_2_6_table', 1),
(47, '2026_01_13_164209_create_jobs_table', 1),
(48, '2026_02_19_153901_create_tournaments_table', 1),
(49, '2026_02_19_154014_create_teams_table', 1),
(50, '2026_02_19_154020_create_players_table', 1),
(51, '2026_02_19_154025_create_player_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'category-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(2, 'category-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(3, 'category-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(4, 'category-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(5, 'category-order-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(6, 'sub-category-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(7, 'sub-category-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(8, 'sub-category-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(9, 'sub-category-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(10, 'sub-category-order-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(11, 'tag-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(12, 'tag-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(13, 'tag-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(14, 'tag-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(15, 'news-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(16, 'news-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(17, 'news-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(18, 'news-edit-description', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(19, 'news-clone', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(20, 'news-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(21, 'news-bulk-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(22, 'breaking-news-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(23, 'breaking-news-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(24, 'breaking-news-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(25, 'breaking-news-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(26, 'breaking-news-bulk-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(27, 'live-streaming-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(28, 'live-streaming-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(29, 'live-streaming-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(30, 'live-streaming-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(31, 'rss-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(32, 'rss-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(33, 'rss-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(34, 'rss-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(35, 'rss-bulk-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(36, 'featured-section-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(37, 'featured-section-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(38, 'featured-section-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(39, 'featured-section-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(40, 'featured-section-order-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(41, 'ad-space-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(42, 'ad-space-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(43, 'ad-space-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(44, 'ad-space-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(45, 'user-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(46, 'user-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(47, 'comment-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(48, 'comment-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(49, 'comment-bulk-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(50, 'comment-flag-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(51, 'comment-flag-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(52, 'notification-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(53, 'notification-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(54, 'notification-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(55, 'survey-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(56, 'survey-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(57, 'survey-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(58, 'survey-view', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(59, 'survey-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(60, 'survey-bulk-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(61, 'location-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(62, 'location-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(63, 'location-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(64, 'location-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(65, 'page-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(66, 'page-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(67, 'page-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(68, 'page-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(69, 'staff-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(70, 'staff-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(71, 'staff-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(72, 'staff-change-password', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(73, 'staff-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(74, 'role-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(75, 'role-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(76, 'role-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(77, 'role-view', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(78, 'role-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(79, 'general-settings', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(80, 'panel-settings', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(81, 'web-settings', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(82, 'app-settings', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(83, 'language-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(84, 'language-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(85, 'language-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(86, 'language-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(87, 'seo-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(88, 'seo-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(89, 'seo-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(90, 'seo-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(91, 'firebase-configuration', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(92, 'social-media-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(93, 'social-media-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(94, 'social-media-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(95, 'social-media-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(96, 'system-update', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(97, 'author-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(98, 'author-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(99, 'tournament-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(100, 'tournament-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(101, 'tournament-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(102, 'tournament-view', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(103, 'tournament-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(104, 'player-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(105, 'player-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(106, 'player-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(107, 'player-view', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(108, 'player-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(109, 'team-list', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(110, 'team-create', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(111, 'team-edit', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(112, 'team-view', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(113, 'team-delete', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_details`
--

CREATE TABLE `player_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `role` tinyint(4) DEFAULT NULL,
  `batting_style` varchar(255) DEFAULT NULL,
  `bowling_style` varchar(255) DEFAULT NULL,
  `original_proof` varchar(255) DEFAULT NULL,
  `base_price` varchar(255) DEFAULT NULL,
  `sold_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(2, 'Member', 'admin', '2026-03-05 07:55:11', '2026-03-05 07:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(99, 2),
(100, 1),
(100, 2),
(101, 1),
(102, 1),
(102, 2),
(103, 1),
(103, 2),
(104, 1),
(104, 2),
(105, 1),
(105, 2),
(106, 1),
(106, 2),
(107, 1),
(107, 2),
(108, 1),
(108, 2),
(109, 1),
(109, 2),
(110, 1),
(110, 2),
(111, 1),
(111, 2),
(112, 1),
(112, 2),
(113, 1),
(113, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ad_spaces`
--

CREATE TABLE `tbl_ad_spaces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `ad_space` varchar(255) NOT NULL,
  `ad_featured_section_id` int(11) NOT NULL,
  `ad_image` varchar(255) DEFAULT NULL,
  `web_ad_image` varchar(255) DEFAULT NULL,
  `ad_url` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0-deactive, 1-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_authors`
--

CREATE TABLE `tbl_authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bio` text DEFAULT NULL,
  `telegram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `whatsapp_link` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_breaking_news`
--

CREATE TABLE `tbl_breaking_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content_type` varchar(50) DEFAULT NULL,
  `content_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `summarized_description` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_breaking_news_view`
--

CREATE TABLE `tbl_breaking_news_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `breaking_news_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `row_order` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-unapproved, 1-approved',
  `date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_flag`
--

CREATE TABLE `tbl_comment_flag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0-deactive, 1-active',
  `date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_like`
--

CREATE TABLE `tbl_comment_like` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1-like, 2-dislike',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_notification`
--

CREATE TABLE `tbl_comment_notification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_featured_sections`
--

CREATE TABLE `tbl_featured_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `news_type` varchar(500) DEFAULT NULL,
  `user_ids` varchar(255) DEFAULT NULL COMMENT 'comma separated user_ids of authors',
  `videos_type` varchar(100) DEFAULT NULL,
  `filter_type` varchar(500) DEFAULT NULL,
  `category_ids` varchar(255) NOT NULL,
  `subcategory_ids` varchar(255) NOT NULL,
  `news_ids` varchar(255) NOT NULL,
  `style_app` varchar(100) DEFAULT NULL,
  `style_web` varchar(100) DEFAULT NULL,
  `row_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0-deactive, 1-active',
  `is_based_on_user_choice` tinyint(4) NOT NULL COMMENT '0-filter_section, 1-news from users category',
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `og_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_languages`
--

CREATE TABLE `tbl_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-active, 0-deactive',
  `isRTL` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-yes, 0-no',
  `image` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_languages`
--

INSERT INTO `tbl_languages` (`id`, `language`, `code`, `status`, `isRTL`, `image`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'English (US)', 'en', 1, 0, 'flags/en.webp', 'English (US)', '2026-03-05 07:54:30', '2026-03-05 07:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_live_streaming`
--

CREATE TABLE `tbl_live_streaming` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL DEFAULT 0,
  `tag_id` text NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `title` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `content_type` varchar(50) NOT NULL,
  `content_value` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `summarized_description` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `show_till` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-active, 0-deactive',
  `is_draft` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `is_clone` int(11) NOT NULL DEFAULT 0,
  `is_comment` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 - Comments disabled, 1 - Comments enabled',
  `counter` int(11) NOT NULL DEFAULT 0,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_image`
--

CREATE TABLE `tbl_news_image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` int(11) NOT NULL,
  `other_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_like`
--

CREATE TABLE `tbl_news_like` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1-like, 2-dislike, 0-none',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_view`
--

CREATE TABLE `tbl_news_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `subcategory_id` int(11) NOT NULL DEFAULT 0,
  `news_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(12) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_preference` tinyint(1) NOT NULL DEFAULT 0,
  `date_sent` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `page_type` varchar(50) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `page_content` mediumtext DEFAULT NULL,
  `page_icon` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `is_custom` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0-default, 1-custom',
  `is_termspolicy` tinyint(4) NOT NULL DEFAULT 0,
  `is_privacypolicy` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0-deactive, 1-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `language_id`, `title`, `page_type`, `slug`, `page_content`, `page_icon`, `og_image`, `schema_markup`, `meta_title`, `meta_description`, `meta_keywords`, `is_custom`, `is_termspolicy`, `is_privacypolicy`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Privacy Policy', 'privacy-policy', 'privacy-policy', '<p style=\"text-align: left;\">NEWS APP &amp; CONTENT POLICY</p>', '', '', '', '', 'Privacy Policy', 'Policy', 0, 0, 1, 1, '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(2, 1, 'Terms & Conditions', 'terms-condition', 'terms-condition', '<p style=\"text-align: left;\"><strong>1. Terms Conditions</strong></p>', '', '', '', '', 'Terms & Conditions', 'Terms', 0, 1, 0, 1, '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(3, 1, 'Contact Us', 'contact-us', 'contact-us', '<p style=\"text-align: center;\"><strong>How can we help you?</strong></p>', '', '', '', '', 'Contact Us', 'Contact', 0, 0, 0, 1, '2026-03-05 07:54:30', '2026-03-05 07:54:30'),
(4, 1, 'About Us', 'about-us', 'about-us', '<p><strong>About Us:</strong></p>', '', '', '', '', 'About Us', 'About', 0, 0, 0, 1, '2026-03-05 07:54:30', '2026-03-05 07:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rss`
--

CREATE TABLE `tbl_rss` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL DEFAULT 0,
  `tag_id` varchar(255) NOT NULL,
  `feed_name` varchar(255) NOT NULL,
  `feed_url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-active, 0-deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `type`, `message`, `created_at`, `updated_at`) VALUES
(1, 'rss_feed_mode', '1', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(2, 'mobile_login_mode', '0', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(3, 'country_code', 'IN', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(4, 'shareapp_text', 'You can find our app from below url', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(5, 'appstore_app_id', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(6, 'association_file', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(7, 'assetlinks_file', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(8, 'views_auth_mode', '1', '2026-03-05 07:54:26', '2026-03-05 07:54:26'),
(9, 'video_type_preference', 'normal_style', '2026-03-05 07:54:26', '2026-03-05 07:54:26'),
(10, 'app_version', '3.2.6', NULL, NULL),
(11, 'default_language', '1', NULL, NULL),
(12, 'system_timezone', 'Asia/Kolkata', NULL, NULL),
(13, 'app_name', 'News', NULL, NULL),
(14, 'primary_color', '#000000', NULL, NULL),
(15, 'secondary_color', '#ba2028', NULL, NULL),
(16, 'auto_delete_expire_news_mode', '0', NULL, NULL),
(17, 'app_logo_full', 'panel/logo.png', NULL, NULL),
(18, 'app_logo', 'panel/favicon.png', NULL, NULL),
(19, 'smtp_host', 'smtp.googlemail.com', NULL, NULL),
(20, 'smtp_user', 'SMTP User', NULL, NULL),
(21, 'smtp_password', 'SMTP Password', NULL, NULL),
(22, 'smtp_port', '465', NULL, NULL),
(23, 'smtp_crypto', 'tls', NULL, NULL),
(24, 'from_name', 'News', NULL, NULL),
(25, 'category_mode', '1', NULL, NULL),
(26, 'subcategory_mode', '1', NULL, NULL),
(27, 'breaking_news_mode', '1', NULL, NULL),
(28, 'live_streaming_mode', '1', NULL, NULL),
(29, 'comments_mode', '1', NULL, NULL),
(30, 'weather_mode', '0', NULL, NULL),
(31, 'location_news_mode', '0', NULL, NULL),
(32, 'nearest_location_measure', '1000', NULL, NULL),
(33, 'maintenance_mode', '0', NULL, NULL),
(34, 'in_app_ads_mode', '0', NULL, NULL),
(35, 'ads_type', '1', NULL, NULL),
(36, 'google_rewarded_video_id', 'google Rewarded Video Id', NULL, NULL),
(37, 'google_interstitial_id', 'google Interstitial Id', NULL, NULL),
(38, 'google_banner_id', 'google Banner Id', NULL, NULL),
(39, 'google_native_unit_id', 'google Native Unit Id', NULL, NULL),
(40, 'unity_rewarded_video_id', '1', NULL, NULL),
(41, 'unity_interstitial_id', '1', NULL, NULL),
(42, 'unity_banner_id', '1', NULL, NULL),
(43, 'android_game_id', '1', NULL, NULL),
(44, 'ios_in_app_ads_mode', '0', NULL, NULL),
(45, 'ios_ads_type', '1', NULL, NULL),
(46, 'ios_google_rewarded_video_id', 'google Rewarded Video Id', NULL, NULL),
(47, 'ios_google_interstitial_id', 'google Interstitial Id', NULL, NULL),
(48, 'ios_google_banner_id', 'google Banner Id', NULL, NULL),
(49, 'ios_google_native_unit_id', 'google Native Unit Id', NULL, NULL),
(50, 'ios_unity_rewarded_video_id', '1', NULL, NULL),
(51, 'ios_unity_interstitial_id', '1', NULL, NULL),
(52, 'ios_unity_banner_id', '1', NULL, NULL),
(53, 'ios_game_id', '1', NULL, NULL),
(54, 'force_update_app_mode', '0', NULL, NULL),
(55, 'android_app_version', '1.0.0', NULL, NULL),
(56, 'ios_app_version', '1.0.0', NULL, NULL),
(57, 'google_gemini_api_key', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_media`
--

CREATE TABLE `tbl_social_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` char(255) NOT NULL,
  `link` char(255) NOT NULL,
  `row_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `row_order` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_survey_option`
--

CREATE TABLE `tbl_survey_option` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `options` text NOT NULL,
  `counter` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_survey_question`
--

CREATE TABLE `tbl_survey_question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_survey_result`
--

CREATE TABLE `tbl_survey_result` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tag`
--

CREATE TABLE `tbl_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag_name` varchar(100) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `og_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_token`
--

CREATE TABLE `tbl_token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` text NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firebase_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `fcm_id` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-active, 0-deactive',
  `date` datetime NOT NULL,
  `is_author` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_category`
--

CREATE TABLE `tbl_users_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_seo_pages`
--

CREATE TABLE `tbl_web_seo_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `page_type` varchar(50) NOT NULL,
  `og_image` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `schema_markup` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_settings`
--

CREATE TABLE `tbl_web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_web_settings`
--

INSERT INTO `tbl_web_settings` (`id`, `type`, `message`, `created_at`, `updated_at`) VALUES
(1, 'web_name', 'News', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(2, 'light_body_color', '#f5f5f5', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(3, 'light_hover_color', '#122342', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(4, 'light_primary_color', '#ee2934', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(5, 'light_secondary_color', '#1a2e51', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(6, 'light_text_primary_color', '#0f1f40', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(7, 'light_text_secondary_color', '#65686d', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(8, 'light_header_logo', 'logos/header-logo.svg', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(9, 'light_footer_logo', 'logos/footer-logo.svg', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(10, 'light_placeholder_image', 'logos/placeholder.png', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(11, 'dark_body_color', '#0a1935', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(12, 'dark_hover_color', '#15346d', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(13, 'dark_primary_color', '#ce2b2b', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(14, 'dark_secondary_color', '#122342', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(15, 'dark_text_primary_color', '#ffffff', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(16, 'dark_text_secondary_color', '#98a2b3', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(17, 'dark_header_logo', 'logos/header-logo-dark.svg', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(18, 'dark_footer_logo', 'logos/footer-logo-dark.svg', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(19, 'dark_placeholder_image', 'logos/placeholder-dark.png', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(20, 'favicon_icon', 'logos/favicon-icon.png', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(21, 'web_footer_description', 'News Web website is an online platform that provides news and information about various topics, including current events, entertainment, politics, sports, technology, and more.', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(22, 'google_adsense', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(23, 'android_app_link', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(24, 'ios_app_link', '', '2026-03-05 07:54:25', '2026-03-05 07:54:25'),
(25, 'accept_cookie', '0', '2026-03-05 07:54:25', '2026-03-05 07:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `total_teams` int(11) NOT NULL DEFAULT 0,
  `prize_amount` varchar(255) DEFAULT NULL,
  `is_pr_free` tinyint(1) NOT NULL DEFAULT 0,
  `pr_amount` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `organizer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `featured_section_rss_feeds`
--
ALTER TABLE `featured_section_rss_feeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `featured_section_rss_feeds_featured_section_id_foreign` (`featured_section_id`),
  ADD KEY `featured_section_rss_feeds_rss_feed_id_foreign` (`rss_feed_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `players_email_unique` (`email`),
  ADD KEY `players_team_id_foreign` (`team_id`);

--
-- Indexes for table `player_details`
--
ALTER TABLE `player_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_details_player_id_foreign` (`player_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tbl_ad_spaces`
--
ALTER TABLE `tbl_ad_spaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `tbl_authors`
--
ALTER TABLE `tbl_authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_authors_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `tbl_breaking_news`
--
ALTER TABLE `tbl_breaking_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `tbl_breaking_news_view`
--
ALTER TABLE `tbl_breaking_news_view`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `breaking_news_id` (`breaking_news_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `row_order` (`row_order`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `tbl_comment_flag`
--
ALTER TABLE `tbl_comment_flag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `tbl_comment_like`
--
ALTER TABLE `tbl_comment_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_comment_notification`
--
ALTER TABLE `tbl_comment_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `tbl_featured_sections`
--
ALTER TABLE `tbl_featured_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `tbl_live_streaming`
--
ALTER TABLE `tbl_live_streaming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `published_date` (`published_date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_news_image`
--
ALTER TABLE `tbl_news_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `tbl_news_like`
--
ALTER TABLE `tbl_news_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_news_view`
--
ALTER TABLE `tbl_news_view`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `tbl_rss`
--
ALTER TABLE `tbl_rss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social_media`
--
ALTER TABLE `tbl_social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `row_order` (`row_order`);

--
-- Indexes for table `tbl_survey_option`
--
ALTER TABLE `tbl_survey_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `tbl_survey_question`
--
ALTER TABLE `tbl_survey_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `tbl_survey_result`
--
ALTER TABLE `tbl_survey_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `tbl_token`
--
ALTER TABLE `tbl_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users_category`
--
ALTER TABLE `tbl_users_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_web_seo_pages`
--
ALTER TABLE `tbl_web_seo_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_type` (`page_type`);

--
-- Indexes for table `tbl_web_settings`
--
ALTER TABLE `tbl_web_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_tournament_id_foreign` (`tournament_id`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tournaments_organizer_id_foreign` (`organizer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `featured_section_rss_feeds`
--
ALTER TABLE `featured_section_rss_feeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_details`
--
ALTER TABLE `player_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ad_spaces`
--
ALTER TABLE `tbl_ad_spaces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_authors`
--
ALTER TABLE `tbl_authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_breaking_news`
--
ALTER TABLE `tbl_breaking_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_breaking_news_view`
--
ALTER TABLE `tbl_breaking_news_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment_flag`
--
ALTER TABLE `tbl_comment_flag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment_like`
--
ALTER TABLE `tbl_comment_like`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment_notification`
--
ALTER TABLE `tbl_comment_notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_featured_sections`
--
ALTER TABLE `tbl_featured_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_live_streaming`
--
ALTER TABLE `tbl_live_streaming`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_news_image`
--
ALTER TABLE `tbl_news_image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_news_like`
--
ALTER TABLE `tbl_news_like`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_news_view`
--
ALTER TABLE `tbl_news_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_rss`
--
ALTER TABLE `tbl_rss`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_social_media`
--
ALTER TABLE `tbl_social_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_survey_option`
--
ALTER TABLE `tbl_survey_option`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_survey_question`
--
ALTER TABLE `tbl_survey_question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_survey_result`
--
ALTER TABLE `tbl_survey_result`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_token`
--
ALTER TABLE `tbl_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_category`
--
ALTER TABLE `tbl_users_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_web_seo_pages`
--
ALTER TABLE `tbl_web_seo_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_web_settings`
--
ALTER TABLE `tbl_web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `featured_section_rss_feeds`
--
ALTER TABLE `featured_section_rss_feeds`
  ADD CONSTRAINT `featured_section_rss_feeds_featured_section_id_foreign` FOREIGN KEY (`featured_section_id`) REFERENCES `tbl_featured_sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `featured_section_rss_feeds_rss_feed_id_foreign` FOREIGN KEY (`rss_feed_id`) REFERENCES `tbl_rss` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `player_details`
--
ALTER TABLE `player_details`
  ADD CONSTRAINT `player_details_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_authors`
--
ALTER TABLE `tbl_authors`
  ADD CONSTRAINT `tbl_authors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `tournaments_organizer_id_foreign` FOREIGN KEY (`organizer_id`) REFERENCES `admin` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

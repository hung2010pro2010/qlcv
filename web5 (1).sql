-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 16, 2025 lúc 06:19 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web5`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `project_group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `project_group_id`, `name`, `description`, `created_at`) VALUES
(8, 3, 'Thiết kế bao bì sản phẩm', '', '2025-05-19 14:02:49'),
(9, 3, 'Thiết kế Digital', '', '2025-05-19 14:03:04'),
(10, 3, 'Thiết kế POSM', '', '2025-05-19 14:03:15'),
(11, 6, 'Khảo sát nhu cầu thị trường cho sản phẩm mới', '', '2025-05-19 14:04:07'),
(12, 6, 'Cập nhật nhu cầu thị trường cho sản phẩm đang kinh doanh', '', '2025-05-19 14:04:31'),
(13, 6, 'Khảo sát độ hài lòng của khách hàng', '', '2025-05-19 14:04:59'),
(14, 6, 'Khảo sát các chỉ số phân phối', '', '2025-05-19 14:05:15'),
(16, 7, 'Phát triển nhóm sản phẩm chăm sóc cho nam giới', '', '2025-05-19 14:09:16'),
(17, 7, 'Phát triển nhóm sản phẩm chăm sóc và làm đẹp cho nữ giới', '', '2025-05-19 14:13:39'),
(18, 5, 'Sản xuất tin bài truyền thông trên kênh Owned Media', '', '2025-05-19 14:14:25'),
(19, 4, 'Quản trị sàn Thương mại điện tử', '', '2025-05-19 14:16:42'),
(20, 4, 'Quản trị truyền thông Thương mại điện tử', '', '2025-05-19 14:16:59'),
(21, 8, 'Chấm công', '', '2025-05-19 14:36:07'),
(22, 7, 'Phát triển sản phẩm mới nhóm chăm sóc mẳt', '', '2025-05-19 14:39:52'),
(23, 9, '5S và Kaizen', '', '2025-05-19 15:08:10'),
(24, 9, 'Quản trị Hệ thống Thông tin', '', '2025-05-29 14:29:27'),
(25, 10, 'Xây dựng kênh truyền thông \"Sắc màu Việt Nam\"', '', '2025-06-04 09:36:33'),
(26, 10, 'Booking', '', '2025-06-04 09:36:43'),
(27, 8, 'Báo cáo Tháng', '', '2025-06-04 09:47:45'),
(28, 8, 'Báo cáo Quý', '', '2025-06-04 09:47:54'),
(29, 8, 'Báo cáo Năm', '', '2025-06-04 09:48:14'),
(30, 5, 'Truyền thông Nội bộ', '', '2025-06-04 09:53:02'),
(31, 5, 'Truyền thông Owned Media', '', '2025-06-04 09:53:15'),
(32, 5, 'Truyền thông Paid Media', '', '2025-06-04 09:53:26'),
(33, 5, 'Khủng hoảng truyền thông', '', '2025-06-04 09:53:49'),
(34, 11, 'Kế hoạch và Báo cáo', '', '2025-06-06 11:48:32'),
(35, 11, 'Thiết kế sản phẩm', '', '2025-06-06 11:48:55'),
(36, 11, 'Truyền thông', '', '2025-06-06 11:49:06'),
(37, 3, 'Chụp ảnh sản phẩm', '', '2025-07-01 10:13:54'),
(40, 13, 'Sản xuất nội dung TMĐT', '', '2025-07-02 15:57:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'MKT', 'Phòng Marketing', '2025-06-11 10:45:18'),
(2, 'TC', 'Phòng tổ chức', '2025-06-11 10:45:27'),
(3, 'P.TC-KTKD', 'Phòng Tài chính, Kế toán Kinh Doanh', '2025-07-08 11:00:48'),
(4, 'P.KDMB', 'Phòng KD Miền Bắc', '2025-07-08 11:01:21'),
(5, 'VP.DDMN', 'Văn phòng đại diện Miền Nam', '2025-07-08 11:06:21'),
(6, 'P.KHTH', 'Phòng Kế hoạch tổng hợp', '2025-07-08 11:06:31'),
(7, 'P.KTSX-DA', 'Phòng Kế toán sản xuất và Dự án', '2025-07-08 11:06:40'),
(8, 'P.NCPT', 'Phòng Nghiên cứu phát triển', '2025-07-08 11:06:50'),
(9, 'P.HC', 'Phòng Hành chính', '2025-07-08 11:07:01'),
(10, 'P.TC', 'Phòng Tổ chức', '2025-07-08 11:07:11'),
(11, 'P.DBCL', 'Phòng Đảm bảo chất lượng', '2025-07-08 11:07:20'),
(12, 'P.KTCL', 'Phòng Kiểm tra chất lượng', '2025-07-08 11:07:28'),
(13, 'P.CLPC', 'Phòng Chất lượng pháp chế', '2025-07-08 11:07:37'),
(14, 'P.DK', 'Phòng Đăng ký', '2025-07-08 11:07:46'),
(15, 'DKLS', 'Xưởng chiết xuất - Chi nhánh LS', '2025-07-08 11:07:58'),
(16, 'P.KHKV', 'Phòng Kế hoạch kho vận', '2025-07-08 11:08:08'),
(17, 'P.KT', 'Phòng Kỹ thuật', '2025-07-08 11:08:16'),
(18, 'PX.CD', 'Phân xưởng Cơ điện', '2025-07-08 11:08:25'),
(19, 'PX.1-3', 'Phân xưởng 1 3', '2025-07-08 11:08:35'),
(20, 'PX.2-4', 'Phân xưởng 2 4', '2025-07-08 11:08:43'),
(21, 'PX.5', 'Phân xưởng 5', '2025-07-08 11:08:52'),
(22, 'P.DT-NC', 'Phòng Đào tạo & Nghiên cứu', '2025-07-08 11:09:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_subtasks`
--

CREATE TABLE `department_subtasks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `assignee_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'in_progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_subtasks`
--

INSERT INTO `department_subtasks` (`id`, `task_id`, `title`, `assignee_id`, `status`) VALUES
(31, 18, 'fđf', 9, 'cancelled'),
(32, 18, 'sfsfsf', 10, 'cancelled'),
(33, 19, 'fsdf', 9, 'in_progress'),
(34, 20, 'rể', 9, 'in_progress'),
(35, 21, 'fsfsf', 10, 'in_progress');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_subtask_comments`
--

CREATE TABLE `department_subtask_comments` (
  `id` int(11) NOT NULL,
  `subtask_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_subtask_comments`
--

INSERT INTO `department_subtask_comments` (`id`, `subtask_id`, `user_id`, `content`, `created_at`) VALUES
(10, 31, 11, 'fsdf', '2025-07-11 05:16:06'),
(11, 32, 11, 'fdf', '2025-07-11 05:16:09'),
(12, 35, 11, 'dsda', '2025-07-11 11:29:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_subtask_followers`
--

CREATE TABLE `department_subtask_followers` (
  `id` int(11) NOT NULL,
  `subtask_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_subtask_followers`
--

INSERT INTO `department_subtask_followers` (`id`, `subtask_id`, `user_id`) VALUES
(132, 31, 8),
(133, 31, 9),
(134, 32, 9),
(135, 32, 16),
(136, 33, 10),
(137, 34, 16),
(140, 35, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_subtask_reports`
--

CREATE TABLE `department_subtask_reports` (
  `id` int(11) NOT NULL,
  `subtask_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_subtask_reports`
--

INSERT INTO `department_subtask_reports` (`id`, `subtask_id`, `user_id`, `content`, `created_at`, `attachment`, `status`) VALUES
(9, 31, 9, 'ffsdf', '2025-07-11 05:16:47', NULL, 'approved'),
(10, 32, 10, 'dadas', '2025-07-11 05:37:52', NULL, 'approved'),
(11, 33, 9, 'sdfsf', '2025-07-11 06:45:16', NULL, 'approved');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_tasks`
--

CREATE TABLE `department_tasks` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `to_department_id` int(11) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `assigned_at` datetime DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_tasks`
--

INSERT INTO `department_tasks` (`id`, `code`, `title`, `description`, `from_department_id`, `to_department_id`, `assigned_by`, `start_time`, `end_time`, `status`, `assigned_at`, `category_id`, `created_at`, `created_by`) VALUES
(18, 'fffffffffffff', 'ggggggggg', 'gsgsdg', NULL, NULL, 8, '2025-07-12 00:00:00', '2025-07-26 23:59:59', 'completed', '2025-07-11 10:07:10', 2, '2025-07-11 10:07:10', 11),
(19, 'fsdf', 'fsdfs', 'fsdf', NULL, NULL, 8, '2025-07-11 00:00:00', '2025-07-18 23:59:59', '', '2025-07-11 11:01:52', 2, '2025-07-11 11:01:52', 11),
(20, 'GV001', 're', 'rẻ', NULL, NULL, 8, '2025-07-10 00:00:00', '2025-07-19 23:59:59', 'pending', '2025-07-11 15:38:25', 2, '2025-07-11 15:38:25', 11),
(21, 'GV002', 'fsfs', 'fsfsf', NULL, NULL, 8, '2025-07-18 00:00:00', '2025-07-19 23:59:59', 'in_progress', '2025-07-11 15:41:31', 2, '2025-07-11 15:41:31', 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_assignees`
--

CREATE TABLE `department_task_assignees` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Danh sách người chịu trách nhiệm chính cho task liên phòng';

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_categories`
--

CREATE TABLE `department_task_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_task_categories`
--

INSERT INTO `department_task_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Quản lý thiết bị', 'Quản lý thiết bị toàn hệ thống', '2025-07-08 11:54:54'),
(2, 'Quản lý vật tư', 'đfdfdf', '2025-07-08 11:55:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_comments`
--

CREATE TABLE `department_task_comments` (
  `id` int(11) NOT NULL,
  `subtask_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_followers`
--

CREATE TABLE `department_task_followers` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Danh sách người liên quan đến task liên phòng';

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_related_departments`
--

CREATE TABLE `department_task_related_departments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_task_related_departments`
--

INSERT INTO `department_task_related_departments` (`id`, `task_id`, `department_id`) VALUES
(46, 18, 7),
(47, 18, 1),
(48, 19, 1),
(49, 19, 17),
(50, 20, 1),
(51, 20, 17),
(54, 21, 4),
(55, 21, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_related_users`
--

CREATE TABLE `department_task_related_users` (
  `id` int(11) NOT NULL,
  `department_task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department_task_responsibles`
--

CREATE TABLE `department_task_responsibles` (
  `id` int(11) NOT NULL,
  `department_task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department_task_responsibles`
--

INSERT INTO `department_task_responsibles` (`id`, `department_task_id`, `user_id`) VALUES
(107, 18, 8),
(108, 18, 10),
(109, 19, 8),
(110, 19, 9),
(111, 20, 8),
(112, 20, 9),
(115, 21, 8),
(116, 21, 16);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` mediumtext NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(4) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `icon`, `color`, `created_at`, `is_read`) VALUES
(31, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:46:01', 1),
(2, 8, 'Công vi?c \"Truy?n thông\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:32:51', 1),
(3, 8, 'Công vi?c \"Thi?t k?\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:33:02', 1),
(4, 8, 'Công vi?c \"Nghiên c?u th? tr??ng\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:33:09', 1),
(5, 8, 'Công vi?c \"Qu?n tr? phòng\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:33:19', 1),
(6, 8, 'Công vi?c \"Phát tri?n s?n ph?m m?i\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:33:25', 1),
(7, 8, 'Công vi?c \"Truy?n thông\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:33:45', 1),
(8, 1, 'Công vi?c \"Truy?n thông\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:34:10', 1),
(9, 8, 'Công vi?c \"Truy?n thông\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:34:27', 1),
(10, 1, 'Công vi?c \"Truy?n thông\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:34:41', 1),
(11, 1, 'Công vi?c \"Nghiên c?u th? tr??ng\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:41:24', 1),
(12, 1, 'Công vi?c \"Phát tri?n s?n ph?m m?i\" ?ã ???c c?p nh?t.', 'edit', 'bg-orange', '2025-05-27 15:41:46', 1),
(28, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:39:50', 1),
(27, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:38:10', 1),
(17, 1, 'Công việc \"\" đã được tạo.', 'add_circle', 'bg-blue', '2025-05-29 14:31:59', 1),
(18, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-05-29 14:32:55', 1),
(19, 1, 'Đã cập nhật người dùng: \"Đỗ Anh Vũ\"', 'mode_edit', 'bg-orange', '2025-05-29 16:07:54', 1),
(30, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:43:25', 1),
(29, 1, 'Công việc thuộc dự án \"Eskar 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 09:41:43', 1),
(26, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 09:32:49', 1),
(25, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:30:58', 1),
(24, 1, 'Đã thêm người dùng mới: \"Nguyễn Hữu Thắng\"', 'person_add', 'bg-light-green', '2025-06-04 09:26:12', 1),
(32, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 09:46:34', 1),
(33, 1, 'Công việc thuộc dự án \"Nghiên cứu thị trường\" đã bị xóa.', 'delete', 'bg-red', '2025-06-04 09:52:26', 1),
(220, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:07:17', 1),
(36, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:15:31', 1),
(37, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:16:01', 1),
(38, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:16:27', 1),
(39, 1, 'Công việc thuộc dự án \"Phát triển sản phẩm mới\" đã bị xóa.', 'delete', 'bg-red', '2025-06-04 10:16:41', 1),
(40, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:17:13', 1),
(41, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:17:48', 1),
(42, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:19:11', 1),
(43, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:21:26', 1),
(219, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-01 15:46:14', 1),
(45, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:25:00', 1),
(46, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:25:13', 1),
(47, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:35:34', 1),
(48, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:36:25', 1),
(49, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:37:32', 1),
(50, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:38:19', 1),
(51, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:39:19', 1),
(52, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:40:33', 1),
(53, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:41:03', 1),
(54, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:41:18', 1),
(55, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã bị xóa.', 'delete', 'bg-red', '2025-06-04 10:41:32', 1),
(56, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:42:19', 1),
(57, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:42:49', 1),
(58, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:43:52', 1),
(59, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã bị xóa.', 'delete', 'bg-red', '2025-06-04 10:44:10', 1),
(60, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:44:42', 1),
(61, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:44:54', 1),
(62, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:45:05', 1),
(63, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:45:14', 1),
(64, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:45:28', 1),
(65, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 10:48:38', 1),
(218, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 15:33:21', 1),
(67, 10, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:54:14', 1),
(68, 16, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:55:10', 1),
(69, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:55:37', 1),
(70, 17, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:55:43', 1),
(71, 8, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:55:51', 1),
(72, 9, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:55:57', 0),
(73, 8, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:56:00', 1),
(74, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:56:09', 1),
(75, 8, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:56:27', 1),
(76, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:56:57', 1),
(77, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:57:15', 1),
(78, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:57:22', 1),
(79, 15, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 10:58:20', 0),
(81, 9, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 11:00:44', 0),
(82, 9, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 11:49:46', 0),
(217, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-01 14:29:14', 1),
(216, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-01 14:24:33', 1),
(215, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-01 10:14:56', 1),
(214, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 08:58:55', 1),
(87, 18, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 13:51:42', 1),
(88, 1, 'Công việc thuộc dự án \"Truyền thông\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 14:06:28', 1),
(89, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-04 14:09:01', 1),
(90, 9, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-04 14:16:19', 0),
(91, 9, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-05 09:42:15', 0),
(92, 18, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-05 09:48:00', 1),
(93, 9, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-05 17:13:14', 0),
(94, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 08:46:21', 1),
(95, 1, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 08:58:09', 1),
(96, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 08:59:34', 1),
(97, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 08:59:45', 1),
(98, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 08:59:53', 1),
(99, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 09:00:07', 1),
(100, 13, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 09:00:09', 1),
(101, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 09:00:18', 1),
(102, 1, 'Công việc thuộc dự án \"Nghiên cứu thị trường\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-06 11:47:39', 1),
(103, 1, 'Công việc thuộc dự án \"Zanzi 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-06 11:49:57', 1),
(104, 1, 'Công việc thuộc dự án \"Zanzi 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-06 11:51:53', 1),
(213, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã bị xóa.', 'delete', 'bg-red', '2025-07-01 08:57:13', 1),
(212, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 08:55:52', 1),
(211, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 08:54:52', 1),
(210, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 08:54:32', 1),
(111, 13, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 15:23:48', 1),
(112, 10, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 15:41:52', 1),
(113, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-06 15:44:14', 1),
(114, 15, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-06 15:45:13', 0),
(209, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-01 08:54:14', 1),
(116, 8, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-07 12:12:53', 1),
(117, 18, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-07 14:13:50', 1),
(118, 8, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-07 18:28:07', 1),
(119, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-07 18:54:27', 1),
(120, 18, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-07 21:52:34', 1),
(208, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:33:51', 1),
(207, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:20:46', 1),
(206, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:19:58', 1),
(205, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:17:00', 1),
(204, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:13:11', 1),
(203, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:12:33', 1),
(202, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 18:09:30', 1),
(201, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 10:01:49', 1),
(200, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-27 10:01:48', 1),
(199, 1, 'Công việc thuộc dự án \"Quản trị phòng\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-27 10:01:31', 1),
(133, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-11 10:47:44', 1),
(134, 1, 'Công việc thuộc dự án \"Thiết kế\" đã bị xóa.', 'delete', 'bg-red', '2025-06-11 10:48:02', 1),
(135, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-11 10:48:26', 1),
(137, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-11 13:49:29', 1),
(198, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-26 09:03:31', 1),
(140, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-11 15:30:05', 1),
(141, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-12 10:31:31', 1),
(197, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-25 10:58:32', 1),
(196, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-25 10:57:36', 1),
(195, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-25 10:56:38', 1),
(145, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:32:32', 1),
(146, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:33:58', 1),
(147, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:34:31', 1),
(148, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:35:12', 1),
(149, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:35:54', 1),
(150, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:36:24', 1),
(151, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:36:58', 1),
(152, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:37:32', 1),
(153, 1, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:38:25', 1),
(154, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:38:48', 1),
(155, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:39:22', 1),
(156, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:39:46', 1),
(157, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:40:07', 1),
(158, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:40:25', 1),
(159, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:40:58', 1),
(160, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:41:22', 1),
(161, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:41:39', 1),
(162, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:42:00', 1),
(163, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:42:29', 1),
(164, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:42:48', 1),
(165, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:43:48', 1),
(166, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:44:06', 1),
(167, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:44:49', 1),
(168, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:45:18', 1),
(169, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:45:46', 1),
(170, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:46:18', 1),
(171, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:46:59', 1),
(172, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-12 13:47:10', 1),
(173, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-12 15:20:10', 1),
(174, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-13 09:11:27', 1),
(175, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-13 10:02:24', 1),
(194, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-25 10:56:16', 1),
(193, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-23 17:19:10', 1),
(192, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-23 17:18:50', 1),
(180, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-14 17:31:31', 1),
(181, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-14 17:55:16', 1),
(182, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-15 16:16:34', 1),
(183, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-15 16:31:18', 1),
(184, 1, 'Công việc thuộc dự án \"Eskar 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-18 16:31:00', 1),
(185, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-19 16:24:56', 1),
(186, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-20 11:56:53', 1),
(187, 1, 'Công việc thuộc dự án \"Nghiên cứu thị trường\" đã được tạo.', 'add_circle', 'bg-blue', '2025-06-21 09:53:47', 1),
(188, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-21 09:54:12', 1),
(189, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-21 09:54:36', 1),
(190, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-21 11:06:09', 1),
(191, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-06-21 15:20:21', 1),
(221, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:17:09', 1),
(222, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:25:11', 1),
(223, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:25:39', 1),
(224, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:26:05', 1),
(225, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:30:25', 1),
(226, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:30:34', 1),
(227, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:31:27', 1),
(228, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:32:12', 1),
(229, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:37:30', 1),
(230, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:37:59', 1),
(231, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:38:11', 1),
(232, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:38:21', 1),
(233, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:38:26', 1),
(234, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:38:33', 1),
(235, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:39:30', 1),
(236, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:39:35', 1),
(237, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:40:26', 1),
(238, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:40:34', 1),
(239, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:42:03', 1),
(240, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:43:32', 1),
(241, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:43:36', 1),
(242, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:44:27', 1),
(243, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:44:33', 1),
(244, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:46:01', 1),
(245, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:46:06', 1),
(246, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:50:37', 1),
(247, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:50:47', 1),
(248, 1, 'Công việc thuộc dự án \"Eskar 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:53:00', 1),
(249, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:53:08', 1),
(250, 1, 'Công việc thuộc dự án \"Eskar 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:54:22', 1),
(251, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:54:28', 1),
(252, 1, 'Công việc \"Eskar 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:54:38', 1),
(253, 1, 'Công việc thuộc dự án \"Nghiên cứu thị trường\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:56:15', 1),
(254, 1, 'Công việc \"Nghiên cứu thị trường\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:56:20', 1),
(255, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 15:56:52', 1),
(256, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 15:56:57', 1),
(257, 1, 'Công việc thuộc dự án \"Quản trị phòng\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:01:07', 1),
(258, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:01:17', 1),
(259, 1, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:03:13', 1),
(260, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:03:18', 1),
(261, 1, 'Công việc thuộc dự án \"Truyền thông\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:05:15', 1),
(262, 1, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:05:20', 1),
(263, 1, 'Công việc thuộc dự án \"Truyền thông\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:07:22', 1),
(264, 1, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:07:27', 1),
(265, 1, 'Công việc thuộc dự án \"Thiết kế\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:08:27', 1),
(266, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:08:43', 1),
(267, 1, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:08:49', 1),
(268, 1, 'Công việc \"Truyền thông\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:08:56', 1),
(269, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:09:03', 1),
(270, 1, 'Công việc \"Quản trị phòng\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:09:12', 1),
(271, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:11:16', 1),
(272, 1, 'Công việc \"Đổi mới sáng tạo và Chuyển đổi số\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:11:24', 1),
(273, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:13:03', 1),
(274, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:13:09', 1),
(275, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:14:26', 1),
(276, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:14:34', 1),
(277, 1, 'Công việc thuộc dự án \"Zanzi 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:18:23', 1),
(278, 1, 'Công việc \"Zanzi 2025\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:18:28', 1),
(279, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã bị xóa.', 'delete', 'bg-red', '2025-07-02 16:19:07', 1),
(280, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã bị xóa.', 'delete', 'bg-red', '2025-07-02 16:19:15', 1),
(281, 1, 'Công việc thuộc dự án \"Đổi mới sáng tạo và Chuyển đổi số\" đã bị xóa.', 'delete', 'bg-red', '2025-07-02 16:19:24', 1),
(282, 1, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:20:52', 1),
(283, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:20:58', 1),
(284, 1, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:21:25', 1),
(285, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:21:30', 1),
(286, 1, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:21:52', 1),
(287, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:21:57', 1),
(288, 1, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:22:49', 1),
(289, 1, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:22:56', 1),
(290, 1, 'Công việc thuộc dự án \"Thương mại điện tử\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-02 16:24:40', 1),
(291, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:24:46', 1),
(292, 1, 'Công việc \"Thương mại điện tử\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-02 16:32:12', 1),
(293, 11, 'Đã cập nhật người dùng: \"Ngô Hải Yến\"', 'mode_edit', 'bg-orange', '2025-07-08 14:46:58', 1),
(294, 11, 'Đã cập nhật người dùng: \"Nguyễn Hương Ly\"', 'mode_edit', 'bg-orange', '2025-07-08 14:47:05', 1),
(295, 11, 'Đã cập nhật người dùng: \"Nguyễn Phương Loan\"', 'mode_edit', 'bg-orange', '2025-07-10 15:50:41', 1),
(296, 11, 'Đã cập nhật người dùng: \"Vũ Bích Phương\"', 'mode_edit', 'bg-orange', '2025-07-10 15:50:46', 1),
(297, 11, 'Đã cập nhật người dùng: \"Nguyễn Hương Ly\"', 'mode_edit', 'bg-orange', '2025-07-10 16:08:20', 1),
(298, 11, 'Đã cập nhật người dùng: \"Nguyễn Phương Loan\"', 'mode_edit', 'bg-orange', '2025-07-10 16:08:34', 1),
(299, 11, 'Đã cập nhật người dùng: \"Vũ Bích Phương\"', 'mode_edit', 'bg-orange', '2025-07-10 16:09:27', 1),
(300, 11, 'Đã cập nhật người dùng: \"Nguyễn Hương Ly\"', 'mode_edit', 'bg-orange', '2025-07-11 10:16:27', 1),
(301, 8, 'Công việc thuộc dự án \"Sản xuất nội dung\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-12 11:21:52', 0),
(302, 8, 'Công việc \"Thiết kế\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-12 11:55:10', 0),
(303, 8, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-12 11:55:21', 0),
(304, 8, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-12 11:56:31', 0),
(305, 8, 'Công việc \"Sản xuất nội dung\" đã được cập nhật.', 'edit', 'bg-orange', '2025-07-12 11:59:43', 0),
(306, 11, 'Công việc thuộc dự án \"Zanzi 2025\" đã được tạo.', 'add_circle', 'bg-blue', '2025-07-12 14:43:15', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_groups`
--

CREATE TABLE `project_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `project_groups`
--

INSERT INTO `project_groups` (`id`, `name`, `description`, `created_at`) VALUES
(3, 'Thiết kế', '', '2025-05-14 13:50:54'),
(4, 'Thương mại điện tử', '', '2025-05-14 13:51:00'),
(5, 'Truyền thông', '', '2025-05-18 21:01:08'),
(6, 'Nghiên cứu thị trường', '', '2025-05-19 13:59:39'),
(7, 'Phát triển sản phẩm mới', '', '2025-05-19 13:59:48'),
(8, 'Quản trị phòng', '', '2025-05-19 14:12:31'),
(9, 'Đổi mới sáng tạo và Chuyển đổi số', '', '2025-05-19 15:07:46'),
(10, 'Eskar 2025', '', '2025-06-04 09:34:17'),
(11, 'Zanzi 2025', '', '2025-06-06 11:47:52'),
(13, 'Sản xuất nội dung', '', '2025-07-02 15:57:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_code` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `detail` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `responsible_person` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `approval_status` varchar(50) DEFAULT NULL,
  `task_status` varchar(50) DEFAULT NULL,
  `receive_time` datetime DEFAULT NULL,
  `attachment_path` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `project_group` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `approval_time` datetime DEFAULT NULL,
  `status_time` datetime DEFAULT NULL,
  `department_task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`id`, `task_code`, `created_at`, `detail`, `requirements`, `priority`, `start_date`, `due_date`, `responsible_person`, `assigned_to`, `approval_status`, `task_status`, `receive_time`, `attachment_path`, `created_by`, `project_group`, `category`, `approval_time`, `status_time`, `department_task_id`) VALUES
(26, 'TASK0001', '2025-05-19 11:46:30', 'Sản xuất Video trên kênh \"Sắc màu Việt Nam\" trên Tiktok', '', '2', '2025-06-04', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 10, 25, '2025-07-02 15:31:27', '2025-07-02 08:25:49', NULL),
(27, 'TASK0027', '2025-05-19 14:30:36', 'Thiết kế bộ sản phẩm thuốc Generic Hoá dược: 08 sản phẩm. Bao gồm: Bộ Hô hấp (07 sản phẩm). Vitamin và Khoáng chất (01 sản phẩm)', 'Thiết kế theo key visual của S-River đã được duyệt', '2', '2025-06-04', '2025-06-28', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-27 18:20:46', '2025-06-27 10:49:57', NULL),
(29, 'TASK0029', '2025-05-19 14:37:00', 'Chấm công hàng tháng', 'Thực hiện theo biểu mẫu và quy trình ', '2', '2025-06-01', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 8, 21, '2025-07-02 15:07:17', '2025-07-01 03:02:49', NULL),
(33, 'TASK0033', '2025-05-29 14:31:59', 'Hoàn thiện phiên bản Web App của phần mềm quản lý công việc (tháng 6/2025)', '', '2', '2025-06-01', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 9, 24, '2025-06-25 10:58:32', '2025-06-06 15:01:56', NULL),
(34, 'TASK0034', '2025-06-04 09:32:49', 'Chụp ảnh và thiết kế ảnh Thumb của sản phẩm Elemis Bubble', '', '2', '2025-06-04', '2025-06-07', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 9, '2025-06-12 13:44:49', '2025-06-04 02:31:27', NULL),
(35, 'TASK0035', '2025-06-04 09:41:43', 'Chốt danh sách Booking tháng 7 cho khu vực Miền Nam theo danh sách các tỉnh bao phủ', '', '1', '2025-06-01', '2025-06-07', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 10, 26, '2025-06-12 13:44:06', '2025-06-07 18:54:27', NULL),
(36, 'TASK0036', '2025-06-04 10:19:11', 'Sản xuất Video kênh TMĐT', '', '2', '2025-06-01', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 20, '2025-06-27 18:33:51', '2025-06-27 10:50:07', NULL),
(37, 'TASK0037', '2025-06-04 10:21:26', 'Sửa thiết kế bao bì theo yêu cầu của phòng Đăng ký', '', '2', '2025-06-04', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-27 18:19:58', '2025-06-27 10:54:30', NULL),
(38, 'TASK0038', '2025-06-04 10:35:34', 'Vận hành 2 sàn TMĐT Shopee và Tiktok hoạt động ổn định và đạt được hiệu suất tiêu chuẩn', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 19, '2025-07-02 15:26:05', '2025-07-02 08:22:08', NULL),
(39, 'TASK0039', '2025-06-04 10:36:25', 'Theo dõi các chỉ số SEO Onpage của website dkpharma.vn', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 9, 24, '2025-07-01 08:55:52', '2025-06-27 14:53:19', NULL),
(40, 'TASK0040', '2025-06-04 10:37:32', 'Hỗ trợ các đơn vị thành viên xử lý các vấn đề về mạng và máy tính', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 9, 24, '2025-07-01 08:54:52', '2025-06-27 14:40:59', NULL),
(41, 'TASK0041', '2025-06-04 10:38:19', 'Cập nhật, sửa lỗi các hệ thống website trong hệ thống', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 9, 24, '2025-07-01 08:54:32', '2025-06-27 14:39:38', NULL),
(42, 'TASK0042', '2025-06-04 10:39:19', 'Hỗ trợ công việc của Ban Chuyển đổi số', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 9, 24, '2025-07-01 08:54:14', '2025-06-27 14:33:10', NULL),
(43, 'TASK0043', '2025-06-04 10:40:33', 'Sản xuất video trên các kênh TMĐT', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 20, '2025-07-02 15:25:39', '2025-07-02 08:23:04', NULL),
(44, 'TASK0044', '2025-06-04 10:41:03', 'Sản xuất video trên các kênh TMĐT', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 20, '2025-07-02 15:32:12', '2025-07-02 08:26:13', NULL),
(45, 'TASK0045', '2025-06-04 10:42:19', 'Sản xuất video trên các kênh TMĐT', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 20, '2025-07-01 08:58:55', '2025-07-01 01:31:40', NULL),
(46, 'TASK0046', '2025-06-04 10:42:49', 'Sản xuất video trên các kênh TMĐT', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 20, '2025-07-02 15:42:03', '2025-07-02 08:33:51', NULL),
(48, 'TASK0047', '2025-06-04 10:48:38', 'Quản trị 2 sàn TMĐT đạt được các mục tiêu Doanh thu, ROAS', '', '2', '2025-06-02', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 19, '2025-07-01 15:33:21', '2025-07-01 07:26:53', NULL),
(49, 'TASK0049', '2025-06-04 14:06:28', 'Thêm thông tin sản phẩm Elemis Bubble', '', '2', '2025-06-04', '2025-06-07', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 5, 18, '2025-06-12 13:38:25', '2025-06-06 15:46:31', NULL),
(50, 'TASK0050', '2025-06-04 14:09:01', 'Lên kế hoạch từ khóa, combo và chính sách phát triển nhóm sản phẩm trọng tâm cho sàn Shopee: Tắm DAN, Xịt muỗi DAN, Lovie, DK-Betics', '', '2', '2025-06-04', '2025-06-07', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 4, 19, '2025-06-12 13:37:32', '2025-06-07 14:13:50', NULL),
(51, 'TASK0051', '2025-06-06 11:47:39', 'Khảo sát nhu cầu thị trường TMĐT cho nhóm sản phẩm Mỹ phẩm và TPCN với đối tượng Mẹ và Bé', 'Sử dụng dữ liệu từ Metric.vn', '2', '2025-06-09', '2025-06-14', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 6, 12, '2025-06-25 10:56:38', '2025-06-14 12:18:23', NULL),
(52, 'TASK0052', '2025-06-06 11:49:57', 'Xây dựng kế hoạch tổng thể cho dự án Zanzi 2025', '', '2', '2025-06-09', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 11, 34, '2025-07-02 15:30:34', '2025-07-02 08:21:10', NULL),
(53, 'TASK0053', '2025-06-06 11:51:53', 'Thiết kế Key visual và cho các sản phẩm trong bộ Zanzi 2025', '', '2', '2025-06-06', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 11, 35, '2025-07-02 15:30:25', '2025-07-02 08:21:36', NULL),
(55, 'TASK0054', '2025-06-06 15:44:14', 'Xây dựng Đề án phát triển giải pháp truy xuất nguồn gốc theo từng lô sản phẩm của DK dùng mã QR', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Điều chỉnh nội dung', 'Đang thực hiện', NULL, '', 1, 9, 24, NULL, '2025-06-13 17:17:35', NULL),
(57, 'TASK0056', '2025-06-11 10:47:19', 'Thiết kế bao bì nhãn Bohexin Forte theo nội dung HDSD trong email của phòng đăng ký\r\n', 'Theo nhận diện của nhãn Bohexin', '1', '2025-06-11', '2025-06-14', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-14 17:55:16', '2025-06-14 08:52:32', NULL),
(58, 'TASK0058', '2025-06-12 10:29:42', 'Sửa thiết kế TMT Sensitive để đăng ký Mỹ phẩm theo yêu cầu trong email', '', '1', '2025-06-12', '2025-06-14', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-21 09:54:36', '2025-06-14 12:25:10', NULL),
(59, 'TASK0059', '2025-06-12 10:31:31', 'Thiết kế Chứng nhận nhà thuốc phân phối chính hãng sản phẩm DKPharma theo yêu cầu trong email', '', '1', '2025-06-12', '2025-06-14', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 9, '2025-06-14 17:31:31', '2025-06-14 10:05:16', NULL),
(61, 'TASK0060', '2025-06-12 15:20:10', 'Thiết kế sản phẩm DK-Proxen theo nhận diện mới nhóm Hóa dược', '', '2', '2025-06-16', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-27 18:17:00', '2025-06-27 10:40:57', NULL),
(63, 'TASK0062', '2025-06-18 16:31:00', 'Ký hợp đồng Booking với hệ thống nhà thuốc Long Châu', '', '1', '2025-06-18', '2025-06-27', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 10, 26, '2025-06-27 18:13:11', '2025-06-27 10:52:14', NULL),
(64, 'TASK0064', '2025-06-21 09:53:47', 'Khảo sát dịch vụ chăm sóc mẹ và tắm bé (có thông tin online) tại Việt Nam', '', '2', '2025-06-21', '2025-06-25', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 6, 11, '2025-06-27 18:09:30', '2025-06-27 08:37:41', NULL),
(65, 'TASK0065', '2025-06-23 17:18:50', 'Sửa thiết kế nhãn Eskar, Aladka, Neo-Beta theo email yêu cầu của phòng RA', '', '2', '2025-06-23', '2025-06-27', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 3, 8, '2025-06-27 18:12:33', '2025-06-27 10:32:07', NULL),
(66, 'TASK0066', '2025-06-27 10:01:31', 'Báo cáo cá nhân tháng 6/2025', 'Báo cáo theo biểu mẫu: https://docs.google.com/document/d/16-OreIL61YAN62QJHCphRe2ZKdoSoMwV/edit?usp=sharing&ouid=115640968972410694385&rtpof=true&sd=true', '2', '2025-06-27', '2025-06-30', NULL, NULL, 'Phê duyệt', 'Đã hoàn thành', NULL, '', 1, 8, 27, '2025-07-02 15:17:09', '2025-07-01 10:22:07', NULL),
(67, 'TASK0067', '2025-07-01 10:14:56', 'Chụp ảnh sản phẩm Eskar Fresh và đăng thông tin sản phẩm trên website dkpharma.vn', '', '2', '2025-07-01', '2025-07-05', NULL, NULL, 'Giao việc', 'Trình duyệt', NULL, '', 1, 3, 37, '2025-07-02 15:38:33', '2025-07-05 09:58:00', NULL),
(68, 'TASK0068', '2025-07-01 14:24:33', 'Chụp ảnh sản phẩm Eskar Vietnam Value và thay đổi thông tin trên website dkpharma.vn', '', '2', '2025-07-01', '2025-07-05', NULL, NULL, 'Giao việc', 'Trình duyệt', NULL, '', 1, 3, 37, '2025-07-02 15:38:26', '2025-07-05 10:00:49', NULL),
(69, 'TASK0069', '2025-07-01 14:29:14', 'Phát triển chức năng cho phần mềm Quản lý công việc: (1) Quản lý Khối / Phòng ban; (2) BSC-OKR; (3) KPI', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 9, 24, '2025-07-02 15:38:21', '2025-07-06 16:34:16', NULL),
(70, 'TASK0070', '2025-07-01 15:46:14', 'Thiết kế tờ thông tin đặt bên trong và dán ngoài hộp đóng hàng đơn TMĐT', '', '1', '2025-07-07', '2025-07-12', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 3, 10, '2025-07-02 15:38:11', '2025-07-02 09:52:35', NULL),
(71, 'TASK0071', '2025-07-02 15:37:30', 'Vận hành và đảm bảo hoạt động của website dkpharma và hệ thống website sản phẩm', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 9, 24, '2025-07-02 15:37:59', '2025-07-06 16:34:01', NULL),
(72, 'TASK0072', '2025-07-02 15:39:30', 'Cập nhật, sửa lỗi các website trong hệ thống', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 9, 24, '2025-07-02 15:39:35', '2025-07-06 16:33:36', NULL),
(73, 'TASK0073', '2025-07-02 15:40:26', 'Hỗ trợ DKT, DKBN xử lý các vấn đề kỹ thuật mạng máy tính', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 9, 24, '2025-07-02 15:40:34', '2025-07-06 16:33:09', NULL),
(74, 'TASK0074', '2025-07-02 15:43:32', 'Hỗ trợ công việc của Ban Đổi mới và Chuyển đổi số', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Chưa nhận việc', NULL, '', 1, 9, 23, '2025-07-02 15:43:36', '2025-07-02 15:42:47', NULL),
(76, 'TASK0076', '2025-07-02 15:46:01', 'Thiết kế bao bì sản phẩm mới', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 3, 8, '2025-07-02 15:46:06', '2025-07-02 08:52:23', NULL),
(77, 'TASK0077', '2025-07-02 15:50:37', 'Sửa nhãn theo góp ý của RA', '', '2', '2025-07-01', '2025-07-12', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 3, 8, '2025-07-12 11:55:10', '2025-07-12 11:55:10', 21),
(78, 'TASK0078', '2025-07-02 15:53:00', 'Book hoàn thiện 50 KOC cho tháng 7/2025', '', '2', '2025-07-01', '2025-07-12', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 10, 26, '2025-07-02 15:54:38', '2025-07-03 04:56:46', NULL),
(79, 'TASK0079', '2025-07-02 15:54:22', 'Xây dựng danh sách Booking 50 KOC cho tháng 8/2025', '', '2', '2025-07-14', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 10, 26, '2025-07-02 15:54:28', '2025-07-03 04:56:51', NULL),
(80, 'TASK0080', '2025-07-02 15:56:15', 'Khảo sát nhu cầu thị trường TMĐT với các nhóm sản phẩm có thể khai thác kinh doanh', '', '2', '2025-07-14', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 6, 12, '2025-07-02 15:56:20', '2025-07-03 04:56:55', NULL),
(82, 'TASK0082', '2025-07-02 16:01:07', 'Theo dõi chấm công và gửi bảng chấm công đúng hạn', '', '2', '2025-07-31', '2025-08-02', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 8, 21, '2025-07-02 16:09:12', '2025-07-03 04:56:58', NULL),
(83, 'TASK0083', '2025-07-02 16:03:13', 'Hỗ trợ sản xuất video cho kênh TMĐT', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 13, 40, '2025-07-02 16:09:03', '2025-07-04 03:14:41', NULL),
(84, 'TASK0084', '2025-07-02 16:05:15', 'Hoàn thiện nội dung cho website dkpharma', '', '2', '2025-07-01', '2025-07-05', NULL, NULL, 'Giao việc', 'Trình duyệt', NULL, '', 1, 5, 18, '2025-07-02 16:08:56', '2025-07-05 10:06:18', NULL),
(85, 'TASK0085', '2025-07-02 16:07:22', 'Chỉnh sửa nội dung cho website Eskar', 'Thiết kế layout phù hợp với nhận diện 10 năm Eskar và Vietnam Value. Thể hiện bộ 3 sản phẩm: Eskar, Eskar Fresh, Eskar Tears.', '2', '2025-07-06', '2025-07-12', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 5, 31, '2025-07-02 16:07:27', '2025-07-04 03:15:04', NULL),
(86, 'TASK0086', '2025-07-02 16:08:27', 'Thiết kế Brief sản phẩm cho team TMĐT', '', '2', '2025-07-06', '2025-07-12', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 3, 9, '2025-07-02 16:08:49', '2025-07-04 03:15:48', NULL),
(88, 'TASK0088', '2025-07-02 16:13:03', 'Vận hành 2 sản TMĐT theo kế hoạch', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 4, 19, '2025-07-02 16:13:09', '2025-07-02 09:26:15', NULL),
(89, 'TASK0089', '2025-07-02 16:14:26', 'Booking KOC cho 2 sản phẩm Lovie Drops và Elemis bọt', '', '2', '2025-07-01', '2025-07-12', NULL, NULL, 'Giao việc', 'Chưa nhận việc', NULL, '', 1, 4, 20, '2025-07-02 16:14:34', '2025-07-02 16:13:24', NULL),
(90, 'TASK0090', '2025-07-02 16:18:23', 'Theo dõi, đốc thúc tiến độ chốt công thức, bao bì, đăng ký 4 sản phẩm đầu tiên trong bộ', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 11, 35, '2025-07-02 16:18:28', '2025-07-03 04:42:35', NULL),
(91, 'TASK0091', '2025-07-02 16:20:52', 'Sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 13, 40, '2025-07-02 16:20:58', '2025-07-02 09:50:02', NULL),
(92, 'TASK0092', '2025-07-02 16:21:25', 'Sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 13, 40, '2025-07-02 16:21:30', '2025-07-02 09:29:50', NULL),
(93, 'TASK0093', '2025-07-02 16:21:52', 'Sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 13, 40, '2025-07-02 16:21:57', '2025-07-02 09:26:21', NULL),
(94, 'TASK0094', '2025-07-02 16:22:49', 'Sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Đang thực hiện', NULL, '', 1, 13, 40, '2025-07-02 16:22:56', '2025-07-02 09:46:32', NULL),
(95, 'TASK0095', '2025-07-02 16:24:40', 'Vận hành 2 sàn đạt mục tiêu kinh doanh', '', '2', '2025-07-01', '2025-07-31', NULL, NULL, 'Giao việc', 'Chưa nhận việc', NULL, '', 1, 4, 19, '2025-07-02 16:32:12', '2025-07-02 16:23:09', NULL),
(96, 'TASK0096', '2025-07-12 11:21:52', 'fsfsdfs', 'fdf', '2', '2025-07-16', '2025-07-25', NULL, NULL, 'Giao việc', 'Chưa nhận việc', NULL, '', 8, 13, 40, '2025-07-12 11:59:43', NULL, 20),
(97, 'TASK0097', '2025-07-12 14:43:15', 'fdfsd', '', '1', '2025-07-12', '2025-07-18', NULL, NULL, 'Giao việc', 'Chưa nhận việc', NULL, '', 11, 11, 36, '2025-07-12 14:42:56', '2025-07-12 14:42:56', 21);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_reports`
--

CREATE TABLE `task_reports` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `result_link` mediumtext DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `submitted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_reports`
--

INSERT INTO `task_reports` (`id`, `task_id`, `user_id`, `title`, `result_link`, `content`, `status`, `created_at`, `submitted_at`) VALUES
(1, 35, 8, 'DANH SÁCH BOOKING THÁNG 7 KHU VỰC MIỀN NAM', 'https://docs.google.com/spreadsheets/d/1OsR0zWPq_2w7ZOcaCu4CMWhkkxBEtO6z/edit?gid=1549003069#gid=1549003069', '- Chốt 10 KOC khu vực miền Nam để booking test \r\n', 'Trình duyệt', '2025-06-09 04:05:05', NULL),
(2, 37, 8, 'SỬA NHÃN HEDEKA ', '', '- Đã gửi yêu cầu sửa HDSD, ND theo yêu cầu của phòng Đăng ký cho chị Ly ngày 09/06/2025 \r\n', 'Đang thực hiện', '2025-06-09 04:21:37', '2025-06-09 04:21:37'),
(16, 59, 9, '', '', 'https://drive.google.com/drive/folders/1oeEMuu913VtfU9nZXybemf5DeL-JiUpi?usp=drive_link', 'Trình duyệt', '2025-06-14 10:05:16', NULL),
(17, 58, 8, '', '', '', 'Đang thực hiện', '2025-06-14 10:35:20', '2025-06-14 10:35:20'),
(4, 55, 11, 'Báo cáo đề xuất theo dõi lô sản phẩm', 'https://qrcheck.icheck.vn/qrcode/mapping', 'Sử dụng bên Icheck cung cấp dịch vụ có sẵn\r\nThông tin tài khoản:\r\nTài khoản: mypl\r\nPass: 123456', 'Trình duyệt', '2025-06-10 04:56:03', NULL),
(6, 57, 9, 'Thiết kế bao bì nhãn Bohexin Forte ', '', 'Đã nhận được thông tin', 'Đang thực hiện', '2025-06-12 04:13:42', '2025-06-12 04:13:42'),
(7, 62, 11, '', '', '', 'Đang thực hiện', '2025-06-13 17:14:39', '2025-06-13 17:14:39'),
(8, 62, 11, '', '', '', 'Trình duyệt', '2025-06-13 17:14:45', NULL),
(9, 62, 11, '', '', '', 'Tái trình duyệt', '2025-06-13 17:14:50', NULL),
(10, 55, 11, '', '', '', 'Đang thực hiện', '2025-06-13 17:17:35', '2025-06-13 17:17:35'),
(11, 53, 10, '', '', '', 'Đang thực hiện', '2025-06-14 01:54:56', '2025-06-14 01:54:56'),
(12, 52, 10, '', '', '', 'Đang thực hiện', '2025-06-14 01:55:05', '2025-06-14 01:55:05'),
(13, 61, 8, '', '', '', 'Đang thực hiện', '2025-06-14 02:00:52', '2025-06-14 02:00:52'),
(14, 59, 9, '', '', '', 'Đang thực hiện', '2025-06-14 05:13:12', '2025-06-14 05:13:12'),
(15, 57, 8, '', '', 'FILE THIẾT KẾ BAO BÌ NHÃN BOHEXIN FORTE \r\nQuy cách: \r\n- Hộp 4 vỉ, 6 vỉ x 5 ống 5ml;\r\n- Hộp 4 vỉ, 6 vỉ x 5 ống 10ml;\r\n- Hộp 1 lọ 50ml;\r\n- Tờ HDSD \r\nhttps://drive.google.com/drive/folders/1qS1-cgZJd6fgC2i65C8Og3bdI3jKY-Kj?usp=drive_link', 'Trình duyệt', '2025-06-14 08:52:32', NULL),
(20, 58, 8, '', '', 'File thiết kế TMT Sensitive theo yêu cầu:\r\nhttps://drive.google.com/drive/folders/1HUmU8f7iRBZN7ytOItjnISz8h9kB36Gw?usp=sharing', 'Trình duyệt', '2025-06-14 12:25:10', NULL),
(19, 51, 8, '', '', 'File thông tin dung lượng thị trường, kênh, key players:\r\nhttps://drive.google.com/drive/folders/1Dbgr-Gcvbe-nykbs1P4-DiNMbnzR_X9Q?usp=sharing ', 'Trình duyệt', '2025-06-14 12:18:23', NULL),
(21, 63, 8, '', '', '', 'Đang thực hiện', '2025-06-20 04:42:10', '2025-06-20 04:42:10'),
(24, 65, 8, '', '', '', 'Đang thực hiện', '2025-06-23 10:27:26', '2025-06-23 10:27:26'),
(30, 66, 10, '', '', '', 'Đang thực hiện', '2025-06-27 08:38:42', '2025-06-27 08:38:42'),
(32, 65, 8, '', '', 'File thiết kế \r\nEskar: https://drive.google.com/drive/folders/1iAkV0vNeusKFp0jQjsUXt9U-hH52IDvV?usp=drive_link \r\nAladka: https://drive.google.com/drive/folders/1Z5Omwrhw_1BdJnUGOoyl0hiCESzb9kn6?usp=drive_link \r\nNeo-Beta: https://drive.google.com/drive/folders/1J8PGFSuwt5V6D0bK22ppjLTks5KCdKCW?usp=drive_link', 'Trình duyệt', '2025-06-27 10:32:07', NULL),
(29, 64, 10, '', '', 'https://drive.google.com/file/d/1A_1-kIhxKoupyBb2BNqYM_DizXzO_Ah-/view?usp=sharing', 'Tái trình duyệt', '2025-06-27 08:37:41', NULL),
(31, 66, 16, '', '', 'https://docs.google.com/document/d/1XKW4b8P0MnlK8Lv1AWWjzsBy9wxmbrii/edit', 'Trình duyệt', '2025-06-27 09:54:00', NULL),
(34, 61, 8, '', '', 'File thiết kế DK-Proxen:\r\nhttps://drive.google.com/drive/folders/1MY6Uqf8QnEbJp9MBkT2Vh2YmUNlpz_-s?usp=drive_link', 'Trình duyệt', '2025-06-27 10:40:57', NULL),
(35, 66, 17, '', '', 'Báo cáo công việc tháng 6/2025\r\nhttps://docs.google.com/document/d/1Uz1_OUieMJ3hjk9HBV4FndPHUVQlyTzx/edit?usp=sharing&ouid=110984218083788087941&rtpof=true&sd=true', 'Trình duyệt', '2025-06-27 10:45:07', NULL),
(39, 27, 8, '', '', 'HÔ HẤP:\r\n1. DK-Salbu: https://drive.google.com/drive/folders/1fMM2UfvwTmGpIHkh52VizHfUKJ6aTPCy?usp=drive_link\r\n2. DK-Salbu Neubules 2.5: https://drive.google.com/drive/folders/1Akvf5UF7q00YVFR3uuSSIJ0gdNMtVSUR?usp=drive_link\r\n3. DK-Salbu Neubules 5.0: https://drive.google.com/drive/folders/1RS9MBx2oQ_RbO77k8g15ozwhKEPke2G3?usp=drive_link\r\n4. DK-Salbu Nebules Fort: https://drive.google.com/drive/folders/1jGmi9MMUNVeWoj4s8U_pcoVvY9hXfT0i?usp=drive_link\r\n5. DKasonide Nebules: https://drive.google.com/drive/folders/1lG5NJYCVNCQyW_vLTHPKCxhyq2CBhBLb?usp=drive_link\r\n6. DK-Cisonid : https://drive.google.com/drive/folders/1ff1XnKVXLsBh7UwAZUGWUG8XI2nzd-vS?usp=drive_link\r\n7. Flucason Fort: https://drive.google.com/drive/folders/18lEd3Y-Wr6F10UpdBLW2BQE6-Erfhh_L?usp=drive_link\r\n\r\nVITAMIN VÀ KHOÁNG CHẤT:\r\nhttps://drive.google.com/drive/folders/1IQf3568IcmVCKGRifVsI7WFBSQrISncP?usp=drive_link', 'Trình duyệt', '2025-06-27 10:49:57', NULL),
(45, 41, 11, '', '', '- Hiện trong tháng chưa phát sinh bản cập nhật cho các website của công ty: DKPharma, DKBetics, Yaocaremedic ...\r\n- Gia hạn các tên miền: Eskar\r\n- Thuê mới tên miền: zanzi, sacmauvietnam\r\n', 'Trình duyệt', '2025-06-27 14:39:38', NULL),
(46, 40, 11, '', '', '- Hỗ trợ kết nối máy in cho phòng kế toán DKT, Kiểm tra cây máy tính lỗi cho phòng chăm sóc khách hàng DKT', 'Trình duyệt', '2025-06-27 14:40:59', NULL),
(47, 39, 11, '', '', '1. Hiện tại từ khoá vẫn giữ ổn định, nhưng lưu lượng truy cập đang có sự giảm hơn khoảng 2-3 % so với tháng trước. Có khả năng do nội dung ít được cập nhật thêm\r\n2. Báo cáo từ google Lookestudio\r\nhttps://lookerstudio.google.com/reporting/ef5b917e-09b4-43e6-859c-293e18c9c9f3/page/yrwIE\r\n3. Báo cáo từ Google Webmaster Tools\r\nhttps://search.google.com/search-console/performance/search-analytics?resource_id=https%3A%2F%2Fdkpharma.vn%2F&hl=vi&metrics=CLICKS%2CIMPRESSIONS%2CPOSITION&num_of_months=3', 'Trình duyệt', '2025-06-27 14:53:19', NULL),
(38, 66, 9, '', '', 'Báo cáo tình hình thực hiện công việc tháng 6/2025.\r\nLink: https://docs.google.com/document/d/17CalPwhArASrb7ZDdew54eIsj-bDU2RcM7s8OSA2w0Y/edit?usp=sharing', 'Trình duyệt', '2025-06-27 10:48:22', NULL),
(40, 36, 9, '', '', 'Số video đã làm: 43 video\r\nLink video: https://docs.google.com/spreadsheets/d/1-AYCsgPmaWGcGBaD7XNmlNV2ns9SvMV1/edit?gid=40205822#gid=40205822', 'Trình duyệt', '2025-06-27 10:50:07', NULL),
(41, 63, 8, '', '', 'Danh sách nhà thuốc LC cho hình thức Lightbox và Dummy:\r\nhttps://drive.google.com/drive/folders/1_inDeiO1VKiU7qFL4nAUddU2PIpFVkSE?usp=drive_link', 'Trình duyệt', '2025-06-27 10:52:14', NULL),
(42, 37, 9, '', '', 'Tổng số nhãn đã sửa: 6\r\n- Bohexin Forte (https://drive.google.com/drive/folders/1kE4H-vAIQwWWHkCmCq7B0X55aAnZw1di)\r\n- Proxen (https://drive.google.com/drive/folders/1H2Y0ydoFzWrIxxD_k_cJwM180-zbUUs6)\r\n- TMT Sensitive (https://drive.google.com/drive/folders/1SplyAtv3WoCSf7YLS90IyJtG8iibRxkA)\r\n- Eskar (https://drive.google.com/drive/folders/1iAkV0vNeusKFp0jQjsUXt9U-hH52IDvV)\r\n- Aladka (https://drive.google.com/drive/folders/1Z5Omwrhw_1BdJnUGOoyl0hiCESzb9kn6)\r\n- Neo-beta (https://drive.google.com/drive/folders/1J8PGFSuwt5V6D0bK22ppjLTks5KCdKCW)', 'Trình duyệt', '2025-06-27 10:54:30', NULL),
(44, 42, 11, '', '', '1. Hỗ trợ xây dựng tài liệu tham khảo về quy trình đảm bảo an toàn thông tin trong doanh nghiệp\r\nhttps://docs.google.com/document/d/1vKK74x5UeRSwBsyEeIvP8ueYIdomVJxM/edit?usp=sharing&ouid=117501108061282395844&rtpof=true&sd=true\r\n2. Đang hỗ trợ xây dựng chữ ký số online: Đang triển khai test một số phòng: Phòng nghiên cứu, Phòng Kỹ thuật, Phòng Đảm bảo chất lượng', 'Trình duyệt', '2025-06-27 14:33:10', NULL),
(43, 66, 8, '', '', 'https://docs.google.com/document/d/11EYfsbQsDW0ILceaAQzkO8MdKJcR2OxS/edit', 'Trình duyệt', '2025-06-27 12:25:02', NULL),
(48, 45, 16, '', '', 'https://docs.google.com/document/d/1XKW4b8P0MnlK8Lv1AWWjzsBy9wxmbrii/edit?usp=drive_link&ouid=102308460321319837364&rtpof=true&sd=true', 'Trình duyệt', '2025-07-01 01:31:40', NULL),
(49, 29, 8, '', '', 'BCC Online https://docs.google.com/spreadsheets/d/15nC1YlnwmYtSaNeZSPz2g92sHOz7qfRod6-dkJFJQf8/edit?gid=1641689862#gid=1641689862', 'Trình duyệt', '2025-07-01 03:02:49', NULL),
(50, 66, 18, '', '', 'https://docs.google.com/document/d/1uIEaO_D-gpdUh2tJCLrBKZILoQq0Eh2b/edit?usp=sharing&ouid=114808814631560543345&rtpof=true&sd=true', 'Trình duyệt', '2025-07-01 07:25:54', NULL),
(51, 48, 18, '', '', 'Doanh thu titkok tháng 6  của mình là 359,003,592,  Tiền quảng cáo là 108,262,736 Roi 3.32\r\nDoanh thu shopee tháng 6 66.684.067, Tiền quảng cáo 28,700,000 Roi 2.32\r\nTổng tiền 2 sàn của mình Tháng 6 là 425,687,659 Tiền ads là 136,962,736 Roi 3.1', 'Trình duyệt', '2025-07-01 07:26:53', NULL),
(52, 66, 10, '', '', 'https://docs.google.com/document/d/14cSkXWsdoSocl3C5-rQR4KG3blKG09SZ/edit?usp=drive_link&ouid=106901179221526884641&rtpof=true&sd=true ', 'Trình duyệt', '2025-07-01 10:22:07', NULL),
(61, 26, 8, '', '', 'Danh sách video kênh Sắc Màu Việt Nam tháng 06: \r\nhttps://docs.google.com/spreadsheets/d/1Uj5YFUt2yUzxchQheNCNY5f0nPi3S5Mb7ITAwNPLjwM/edit?gid=822218385#gid=822218385\r\nSỐ LIỆU KÊNH (TÍNH ĐẾN NGÀY 27/06/2025) \r\nFollower: 28.3K\r\nTổng views: 7.595.373\r\nTổng lượt thích: 746.6K', 'Trình duyệt', '2025-07-02 08:25:49', NULL),
(56, 52, 10, '', '', 'https://docs.google.com/spreadsheets/d/1i07wA9pEFlag-_K-HHMX4OBkjCATmk5j/edit?gid=889268008#gid=889268008 ', 'Trình duyệt', '2025-07-02 08:21:10', NULL),
(57, 53, 10, '', '', 'https://drive.google.com/drive/folders/1-n2WGKRwAU2PIJGLpZ5F6dsvBBXBgXAy?usp=drive_link \r\n\r\n', 'Trình duyệt', '2025-07-02 08:21:36', NULL),
(58, 46, 17, '', '', 'Báo cáo công việc tháng 6/2025\r\nhttps://docs.google.com/document/d/1Uz1_OUieMJ3hjk9HBV4FndPHUVQlyTzx/edit?rtpof=true', 'Trình duyệt', '2025-07-02 08:22:02', NULL),
(59, 38, 10, '', '', 'https://docs.google.com/spreadsheets/d/1m8K3GYuTsedoMbtKzueR22s2kBd9mRPxJfsZSTnOozM/edit?gid=1792485332#gid=1792485332 ', 'Trình duyệt', '2025-07-02 08:22:08', NULL),
(60, 43, 13, '', '', 'https://docs.google.com/spreadsheets/d/1-AYCsgPmaWGcGBaD7XNmlNV2ns9SvMV1/edit?gid=721686998#gid=721686998', 'Trình duyệt', '2025-07-02 08:23:04', NULL),
(62, 44, 15, '', '', 'https://docs.google.com/spreadsheets/d/1-AYCsgPmaWGcGBaD7XNmlNV2ns9SvMV1/edit?gid=1160539585#gid=1160539585', 'Trình duyệt', '2025-07-02 08:26:13', NULL),
(63, 46, 17, '', '', 'Báo cáo sản xuất video T6/2025\r\nhttps://docs.google.com/spreadsheets/d/1-AYCsgPmaWGcGBaD7XNmlNV2ns9SvMV1/edit?gid=773342431#gid=773342431', 'Trình duyệt', '2025-07-02 08:33:51', NULL),
(64, 77, 8, '', '', '', 'Đang thực hiện', '2025-07-02 08:52:16', '2025-07-02 08:52:16'),
(65, 76, 8, '', '', '', 'Đang thực hiện', '2025-07-02 08:52:23', '2025-07-02 08:52:23'),
(66, 88, 10, '', '', '', 'Đang thực hiện', '2025-07-02 09:26:15', '2025-07-02 09:26:15'),
(67, 93, 16, '', '', '', 'Đang thực hiện', '2025-07-02 09:26:21', '2025-07-02 09:26:21'),
(68, 92, 17, '', '', '', 'Đang thực hiện', '2025-07-02 09:29:50', '2025-07-02 09:29:50'),
(69, 94, 13, '', '', '', 'Đang thực hiện', '2025-07-02 09:46:32', '2025-07-02 09:46:32'),
(70, 91, 15, '', '', '', 'Đang thực hiện', '2025-07-02 09:50:02', '2025-07-02 09:50:02'),
(71, 67, 9, '', '', '', 'Đang thực hiện', '2025-07-02 09:51:59', '2025-07-02 09:51:59'),
(72, 68, 9, '', '', '', 'Đang thực hiện', '2025-07-02 09:52:19', '2025-07-02 09:52:19'),
(73, 70, 9, '', '', '', 'Đang thực hiện', '2025-07-02 09:52:35', '2025-07-02 09:52:35'),
(74, 90, 10, '', '', 'https://docs.google.com/spreadsheets/d/1h7xv1ty22DbEmA8e7AVSthIQJFM3DKW5rzVQDzjKcO4/edit?usp=sharing', 'Đang thực hiện', '2025-07-03 04:42:35', '2025-07-03 04:42:35'),
(75, 78, 8, '', '', '', 'Đang thực hiện', '2025-07-03 04:56:46', '2025-07-03 04:56:46'),
(76, 79, 8, '', '', '', 'Đang thực hiện', '2025-07-03 04:56:51', '2025-07-03 04:56:51'),
(77, 80, 8, '', '', '', 'Đang thực hiện', '2025-07-03 04:56:55', '2025-07-03 04:56:55'),
(78, 82, 8, '', '', '', 'Đang thực hiện', '2025-07-03 04:56:58', '2025-07-03 04:56:58'),
(79, 83, 9, '', '', '', 'Đang thực hiện', '2025-07-04 03:14:41', '2025-07-04 03:14:41'),
(80, 84, 9, '', '', '', 'Đang thực hiện', '2025-07-04 03:14:54', '2025-07-04 03:14:54'),
(81, 85, 9, '', '', '', 'Đang thực hiện', '2025-07-04 03:15:04', '2025-07-04 03:15:04'),
(82, 86, 9, '', '', '', 'Đang thực hiện', '2025-07-04 03:15:48', '2025-07-04 03:15:48'),
(83, 67, 9, '', '', 'Đã hoàn thiện bộ ảnh sản phẩm Eskar Fresh: https://drive.google.com/drive/folders/1rQGNRfGsEHE3QhcCfYM8pd3yB22CjKWh?usp=sharing\r\nĐă đăng thông tin sản phẩm Eskar Fresh lên website dkpharma.vn: https://dkpharma.vn/cham-soc-mat/dung-dich-nho-mat-eskar-fresh.html', 'Trình duyệt', '2025-07-05 09:58:00', NULL),
(84, 68, 9, '', '', 'Đã thay đổi thông tin Eskar trên website dkpharma.vn : https://dkpharma.vn/cham-soc-mat/thuoc-nho-mat-eskar-15ml.html\r\nBộ ảnh sản phẩm Eskar Vietnam Value: https://drive.google.com/drive/folders/1_DjIgT4MaVmp8Vpo_SmqOyKwTCsvJ35U?usp=sharing', 'Trình duyệt', '2025-07-05 10:00:49', NULL),
(85, 84, 9, '', '', '- Bài post thông báo thay đổi mẫu nhãn Eskar (sửa lần 2): https://docs.google.com/document/d/1NtRJhfZ3Fk-WRE2BcX85GBfz8FKNmfULOF9MnbRIVzM/edit?tab=t.0\r\n- Cập nhật ảnh mới cho sản phẩm Eskar (Vietnam Value): https://dkpharma.vn/cham-soc-mat/thuoc-nho-mat-eskar-15ml.html\r\n- Thêm sản phẩm Eskar Fresh: https://dkpharma.vn/cham-soc-mat/dung-dich-nho-mat-eskar-fresh.html', 'Trình duyệt', '2025-07-05 10:06:18', NULL),
(86, 73, 11, '', '', '', 'Đang thực hiện', '2025-07-06 16:33:09', '2025-07-06 16:33:09'),
(87, 72, 11, '', '', '', 'Đang thực hiện', '2025-07-06 16:33:36', '2025-07-06 16:33:36'),
(88, 71, 11, '', '', '', 'Đang thực hiện', '2025-07-06 16:34:01', '2025-07-06 16:34:01'),
(89, 69, 11, '', '', '', 'Đang thực hiện', '2025-07-06 16:34:16', '2025-07-06 16:34:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_responsible`
--

CREATE TABLE `task_responsible` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `task_responsible`
--

INSERT INTO `task_responsible` (`id`, `task_id`, `user_id`) VALUES
(37, 27, 9),
(38, 37, 8),
(42, 57, 9),
(43, 58, 9),
(45, 61, 9),
(46, 65, 9),
(48, 77, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_results`
--

CREATE TABLE `task_results` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `result_link` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task_results`
--

INSERT INTO `task_results` (`id`, `task_id`, `description`, `result_link`) VALUES
(225, 27, 'DK-Cisonid', ''),
(224, 27, 'DKasonide Neubules', ''),
(223, 27, 'DK-Salbu Neubules Fort', ''),
(253, 26, 'Sản xuất video theo kế hoạch hàng tháng', ''),
(242, 29, 'Bảng chấm công online được hoàn thành và gửi đúng hạn', ''),
(210, 33, 'Hoàn thiện chức năng lịch công việc (Lịch tháng, Lịch tuần)', ''),
(219, 37, 'Sửa bao bì bộ Generic Hóa Dược (8 sản phẩm)', ''),
(248, 38, 'Xử lý đơn hàng hàng ngày tại 3 thời điểm (8h30-14h00-16h00). Cập nhật lên File Google Sheet \"Kế toán đơn hàng DKI\"', ''),
(247, 38, 'Trả lời tin nhắn của khách, rating xấu về sản phẩm. Tổng hợp báo cáo hàng tháng.', ''),
(246, 38, 'Tổng hợp thông tin đơn hàng giao thành công để chuyển kế toán viết hóa đơn. Cập nhật lên File Google Sheet \"Kế toán đơn hàng DKI\"', ''),
(232, 39, 'Báo cáo chỉ số SEO Onpage hàng tháng', ''),
(231, 40, 'Báo cáo xử lý các vấn đề về mạng và máy tính của các đơn vị thành viên tháng 06/2025', ''),
(230, 41, 'Báo cáo cập nhật, sửa lỗi các hệ thống website trong hệ thống tháng 6/2025', ''),
(229, 42, 'Báo cáo công việc hỗ trợ Ban Chuyển đổi số tháng 6/2025', ''),
(267, 46, 'Báo cáo sản xuất video trên các kênh TMĐT tháng 6/2025 (Cập nhật hàng ngày trên link quản lý nhóm content)', ''),
(233, 45, 'Báo cáo sản xuất video trên các kênh TMĐT tháng 6/2025 (Cập nhật hàng ngày trên link quản lý nhóm content)', ''),
(254, 44, 'Báo cáo sản xuất video trên các kênh TMĐT tháng 6/2025 (Cập nhật hàng ngày trên link quản lý nhóm content)', ''),
(245, 43, 'Báo cáo sản xuất video trên các kênh TMĐT tháng 6/2025 (Cập nhật hàng ngày trên link quản lý nhóm content)', ''),
(228, 36, 'Báo cáo sản xuất video trên các kênh TMĐT tháng 6/2025 (Cập nhật hàng ngày trên link quản lý nhóm content)', ''),
(240, 48, 'Chỉ số ROAS của cả 2 sàn gộp không dưới 3.0', ''),
(239, 48, 'Doanh thu tháng 6/2025 tổng 2 sàn Tiktok và Shopee không thấp hơn 500 triệu đồng', ''),
(222, 27, 'DK-Salbu Neubules 2.5', ''),
(153, 49, 'Thông tin sản phẩm được cập nhật đầy đủ trên Website dkpharma.vn', 'https://dkpharma.vn/bo-san-pham-tam-goi/bot-tam-goi-thao-duoc-elemis-bubble-0.html'),
(200, 58, 'Bản thiết kế TMT Sensitive', ''),
(172, 34, 'Bộ ảnh Thumb chuẩn TMĐT', 'https://drive.google.com/drive/folders/1cwIvBgqbk9gjHRNbRCL8pieTWkN58Tvr?usp=sharing'),
(171, 34, 'Bộ ảnh chụp sản phẩm chuẩn TMĐT', 'https://drive.google.com/drive/folders/1u0D6g2oGti58egl0Ubl5sLyBy0ScYo53?usp=sharing'),
(208, 51, 'Báo cáo khảo sát nhu cầu thị trường TMĐT cho nhóm sản phẩm Mỹ phẩm và TPCN với đối tượng Mẹ và Bé', ''),
(252, 52, 'Kế hoạch tổng thể cho dự án Zanzi 2025', ''),
(251, 53, 'Hợp đồng thiết kế', ''),
(201, 55, 'Đề án phát triển giải pháp truy xuất nguồn gốc theo từng lô sản phẩm của DK dùng mã QR', ''),
(170, 35, 'Danh sách Booking tháng 7 khu vực Miền Nam được hoàn thành', 'https://docs.google.com/spreadsheets/d/1OsR0zWPq_2w7ZOcaCu4CMWhkkxBEtO6z/edit?gid=1549003069#gid=1549003069'),
(152, 50, 'Báo cáo và đề xuất từ khóa, combo và chính sách phát triển nhóm sản phẩm trọng tâm cho sàn Shopee: Tắm DAN, Xịt muỗi DAN, Lovie, DK-Betics', 'https://docs.google.com/spreadsheets/d/1vq6TC2FjyltNieSxmQGeE3MaAgFuOj31xAkmjsoI9Js/edit?usp=sharing'),
(192, 57, 'Bản thiết kế bao bì nhãn 5 quy cách', ''),
(191, 59, 'Bản Thiết kế Chứng nhận nhà thuốc phân phối chính hãng sản phẩm DKPharma', ''),
(221, 27, 'DK-Salbu Neubules 5.0', ''),
(218, 61, 'Bản thiết kế sản phẩm DK-Proxen', ''),
(250, 53, 'Mẫu thiết kế Key visual', ''),
(217, 63, 'Hợp đồng Booking với Long Châu', ''),
(215, 64, 'Báo cáo khảo sát dịch vụ chăm sóc mẹ và tắm bé tại Việt Nam', ''),
(249, 53, 'Mẫu thiết kế chi tiết cho các sản phẩm', ''),
(216, 65, 'Thiết kế nhãn Eskar, Aladka, Neo-Beta', ''),
(243, 66, 'Báo cáo cá nhân tháng 6/2025', ''),
(220, 37, 'Sửa bao bì khác (nếu có)', ''),
(226, 27, 'Flucason Fort', ''),
(227, 27, 'DK-Calci Dual Effect', ''),
(262, 67, 'Đăng thông tin sản phẩm Eskar Fresh trên website dkpharma.vn', ''),
(261, 67, 'Chụp ảnh sản phẩm Eskar Fresh', ''),
(260, 68, 'Thông tin mẫu Eskar mới được cập nhật trên website dkpharma.vn', ''),
(259, 68, 'Bộ ảnh sản phẩm Eskar Vietnam Value', ''),
(258, 69, 'Các chức năng cho phần mềm Quản lý công việc: (1) Quản lý Khối / Phòng ban; (2) BSC-OKR; (3) KPI hoạt động đạt yêu cầu', ''),
(257, 70, 'Tờ thông tin đặt bên trong và dán ngoài hộp đóng hàng đơn TMĐT', ''),
(256, 71, 'Tỷ lệ Uptime tối thiểu của mỗi website 99,9%', ''),
(264, 72, 'Báo cáo cập nhật, sửa lỗi các website trong hệ thống', ''),
(266, 73, 'Báo cáo xử lý các vấn đề kỹ thuật mạng máy tính', ''),
(269, 74, 'Báo cáo hỗ trợ công việc của Ban Đổi mới và Chuyển đổi số', ''),
(273, 76, 'Sản phẩm Collagen mới', ''),
(339, 77, 'Sửa nhãn Aladka', ''),
(338, 77, 'Sửa nhãn DK-Proxen', ''),
(337, 77, 'Sửa nhãn Neo-Beta', ''),
(286, 78, 'Bảng theo dõi Booking', ''),
(285, 79, 'Danh sách Booking 50 KOC cho tháng 8/2025', ''),
(288, 80, 'Báo cáo khảo sát nhu cầu thị trường TMĐT với các nhóm sản phẩm có thể khai thác kinh doanh', ''),
(320, 91, 'Báo cáo sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', ''),
(310, 82, 'Bảng chấm công tháng 7/2025', ''),
(309, 83, 'Báo cáo sản xuất video cho kênh TMĐT', ''),
(308, 84, 'Viết post thông báo thay đổi mẫu nhãn Eskar', ''),
(307, 84, 'Cập nhật ảnh mới cho sản phẩm Eskar (Vietnam Value)', ''),
(306, 84, 'Thêm sản phẩm Eskar Fresh', ''),
(302, 85, 'Thiết kế layout website Eskar mới', ''),
(305, 86, 'Brief các sản phẩm trong tháng 7', ''),
(314, 88, 'Báo cáo Vận hành 2 sản TMĐT tháng 7', ''),
(316, 89, 'Bảng theo dõi booking', ''),
(318, 90, 'Báo cáo cập nhật công việc tháng 7', ''),
(322, 92, 'Báo cáo sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', ''),
(324, 93, 'Báo cáo sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', ''),
(326, 94, 'Báo cáo sản xuất video cho kênh truyền thông và bán hàng kênh TMĐT', ''),
(334, 95, 'Doanh số tổng 2 sàn không thấp hơn 900 triệu', ''),
(335, 95, 'Doanh số Shopee không thấp hơn 100 triệu', ''),
(333, 95, 'ROAS tổng 2 sàn không thấp hơn 4.0', ''),
(343, 96, 'fds', ''),
(340, 77, 'Sửa nhãn Aladka-DX', ''),
(344, 96, 'sdsd', ''),
(345, 97, 'fds', ''),
(346, 97, 'fsdfs', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task_supervisors`
--

CREATE TABLE `task_supervisors` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `task_supervisors`
--

INSERT INTO `task_supervisors` (`id`, `task_id`, `user_id`, `role`, `assigned_at`) VALUES
(8, 50, 18, 'chịu trách nhiệm', '2025-06-12 13:37:32'),
(9, 49, 9, 'chịu trách nhiệm', '2025-06-12 13:38:25'),
(22, 35, 8, 'chịu trách nhiệm', '2025-06-12 13:44:06'),
(23, 34, 9, 'chịu trách nhiệm', '2025-06-12 13:44:49'),
(32, 59, 9, 'chịu trách nhiệm', '2025-06-14 17:31:31'),
(33, 57, 8, 'chịu trách nhiệm', '2025-06-14 17:55:16'),
(39, 58, 8, 'chịu trách nhiệm', '2025-06-21 09:54:36'),
(40, 55, 11, 'chịu trách nhiệm', '2025-06-21 11:06:09'),
(45, 51, 8, 'chịu trách nhiệm', '2025-06-25 10:56:38'),
(47, 33, 11, 'chịu trách nhiệm', '2025-06-25 10:58:32'),
(67, 64, 10, 'chịu trách nhiệm', '2025-06-27 18:09:30'),
(68, 65, 8, 'chịu trách nhiệm', '2025-06-27 18:12:33'),
(69, 63, 8, 'chịu trách nhiệm', '2025-06-27 18:13:11'),
(70, 61, 8, 'chịu trách nhiệm', '2025-06-27 18:17:00'),
(71, 37, 9, 'chịu trách nhiệm', '2025-06-27 18:19:58'),
(72, 27, 8, 'chịu trách nhiệm', '2025-06-27 18:20:46'),
(73, 36, 9, 'chịu trách nhiệm', '2025-06-27 18:33:51'),
(74, 42, 11, 'chịu trách nhiệm', '2025-07-01 08:54:14'),
(75, 41, 11, 'chịu trách nhiệm', '2025-07-01 08:54:32'),
(76, 40, 11, 'chịu trách nhiệm', '2025-07-01 08:54:52'),
(77, 39, 11, 'chịu trách nhiệm', '2025-07-01 08:55:52'),
(78, 45, 16, 'chịu trách nhiệm', '2025-07-01 08:58:55'),
(79, 48, 18, 'chịu trách nhiệm', '2025-07-01 15:33:21'),
(80, 29, 8, 'chịu trách nhiệm', '2025-07-02 15:07:17'),
(81, 66, 18, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(82, 66, 17, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(83, 66, 16, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(84, 66, 15, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(85, 66, 13, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(86, 66, 11, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(87, 66, 10, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(88, 66, 9, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(89, 66, 8, 'chịu trách nhiệm', '2025-07-02 15:17:09'),
(91, 43, 13, 'chịu trách nhiệm', '2025-07-02 15:25:39'),
(92, 38, 10, 'chịu trách nhiệm', '2025-07-02 15:26:05'),
(93, 53, 10, 'chịu trách nhiệm', '2025-07-02 15:30:25'),
(94, 52, 10, 'chịu trách nhiệm', '2025-07-02 15:30:34'),
(95, 26, 8, 'chịu trách nhiệm', '2025-07-02 15:31:27'),
(96, 44, 15, 'chịu trách nhiệm', '2025-07-02 15:32:12'),
(97, 71, 11, 'chịu trách nhiệm', '2025-07-02 15:37:59'),
(98, 70, 9, 'chịu trách nhiệm', '2025-07-02 15:38:11'),
(99, 69, 11, 'chịu trách nhiệm', '2025-07-02 15:38:21'),
(100, 68, 9, 'chịu trách nhiệm', '2025-07-02 15:38:26'),
(101, 67, 9, 'chịu trách nhiệm', '2025-07-02 15:38:33'),
(102, 72, 11, 'chịu trách nhiệm', '2025-07-02 15:39:35'),
(103, 73, 11, 'chịu trách nhiệm', '2025-07-02 15:40:34'),
(104, 46, 17, 'chịu trách nhiệm', '2025-07-02 15:42:03'),
(105, 74, 11, 'chịu trách nhiệm', '2025-07-02 15:43:36'),
(107, 76, 8, 'chịu trách nhiệm', '2025-07-02 15:46:06'),
(111, 79, 8, 'chịu trách nhiệm', '2025-07-02 15:54:28'),
(112, 78, 8, 'chịu trách nhiệm', '2025-07-02 15:54:38'),
(113, 80, 8, 'chịu trách nhiệm', '2025-07-02 15:56:20'),
(118, 85, 9, 'chịu trách nhiệm', '2025-07-02 16:07:27'),
(120, 86, 9, 'chịu trách nhiệm', '2025-07-02 16:08:49'),
(121, 84, 9, 'chịu trách nhiệm', '2025-07-02 16:08:56'),
(122, 83, 9, 'chịu trách nhiệm', '2025-07-02 16:09:03'),
(123, 82, 8, 'chịu trách nhiệm', '2025-07-02 16:09:12'),
(125, 88, 10, 'chịu trách nhiệm', '2025-07-02 16:13:09'),
(126, 89, 10, 'chịu trách nhiệm', '2025-07-02 16:14:34'),
(127, 90, 10, 'chịu trách nhiệm', '2025-07-02 16:18:28'),
(128, 91, 15, 'chịu trách nhiệm', '2025-07-02 16:20:58'),
(129, 92, 17, 'chịu trách nhiệm', '2025-07-02 16:21:30'),
(130, 93, 16, 'chịu trách nhiệm', '2025-07-02 16:21:57'),
(131, 94, 13, 'chịu trách nhiệm', '2025-07-02 16:22:56'),
(133, 95, 18, 'chịu trách nhiệm', '2025-07-02 16:32:12'),
(136, 77, 8, 'chịu trách nhiệm', '2025-07-12 11:55:10'),
(141, 96, 17, 'chịu trách nhiệm', '2025-07-12 11:59:43'),
(142, 96, 16, 'chịu trách nhiệm', '2025-07-12 11:59:43'),
(143, 97, 15, 'chịu trách nhiệm', '2025-07-12 14:43:15'),
(144, 97, 11, 'chịu trách nhiệm', '2025-07-12 14:43:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `department`, `position`, `email`, `role`, `department_id`) VALUES
(1, 'anhvu', '$2y$10$Htyt5o4wAwOPk6sAe7zLKeDpTsLCsFJ.EFXXOmQQOn.huPQ7Cc8pG', 'Đỗ Anh Vũ', 0, 'Trưởng phòng', 'anhvu@dkpharma.vn', 'admin', 1),
(8, 'haiyen', '$2y$10$Gl9GrrUGQsJfiKdOlyiGu.OXsR7SU.RSjt.SfNXNAJnG8CG070GWe', 'Ngô Hải Yến', 0, 'Nhân viên', 'haiyen16.dk@gmail.com', 'manager', 1),
(9, 'huongly', '$2y$10$Zac/Ptl1AcBH1Baop/2OcuyLCvFfeR2HDMDU83Y3eZcRLJcUDsCDu', 'Nguyễn Hương Ly', 0, 'Nhân viên', 'lynguyen13399@gmail.com', 'manager', 17),
(10, 'phuongloan', '$2y$10$nqxjTtw2ZQUTwzt7nU1D1eByq8QZLHHod0.HWcyUhoYc8iB0apFqq', 'Nguyễn Phương Loan', 0, 'Nhân viên', 'ploan.dkpharma@gmail.com', 'manager', 7),
(11, 'hungha', '$2y$10$edEp2TMm8fr9PH1RnnDU6.COVuqzgRi0JTgGLsAWuIYIu8JtSNYKu', 'Hạ Văn Hùng', 0, 'Nhân viên', 'hung2010pro2010@gmail.com', 'admin', NULL),
(13, 'phamsen', '$2y$10$Yleu8R9YWygoaCosUBNIRuA8dNj6BoPd2s4Qja/7TAE6ZxSMeoCB2', 'Phạm Thị Sen', 0, 'Nhân viên', 'phamsen.dkpharma@gmail.com', 'nhanvien', 1),
(15, 'levan', '$2y$10$7.dwOdYX3qLqu.Tg0XJ5Ru1OstHiMvrRgX9zRKr4RE9YB9OMRA1Xi', 'Lê Thị Vân', 0, 'Nhân viên', 'vanle.dkpharma@gmail.com', 'nhanvien', 1),
(16, 'bichphuong', '$2y$10$KcWyd8TB6PZRzqg4aiM/HeW4g0FXp67zoaVOEYu40h.jeajqKxX8u', 'Vũ Bích Phương', 0, 'Nhân viên', 'bichphuongvu.dkpharma@gmail.com', 'manager', 4),
(17, 'lananh', '$2y$10$fcDrzhh9eHmolhGOIknbMOa/Fn3JTgtgChvx6WMH585eqHwO3yBG6', 'Nguyễn Lan Anh', 0, 'Nhân viên', 'Lananhnguyen.dkpharma@gmail.com', 'nhanvien', 1),
(18, 'huuthang', '$2y$10$FKpTK4Zb4SJePPMFWOG1OugyF9K8OzwjI0r8dMbNYzbYiR58PYSZa', 'Nguyễn Hữu Thắng', 0, 'Nhân viên', 'nguyenhuuthang134@gmail.com', 'nhanvien', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_group_id` (`project_group_id`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `department_subtasks`
--
ALTER TABLE `department_subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_task` (`task_id`),
  ADD KEY `fk_assignee` (`assignee_id`);

--
-- Chỉ mục cho bảng `department_subtask_comments`
--
ALTER TABLE `department_subtask_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_subtask_comments_ibfk_1` (`subtask_id`);

--
-- Chỉ mục cho bảng `department_subtask_followers`
--
ALTER TABLE `department_subtask_followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtask_id` (`subtask_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_subtask_reports`
--
ALTER TABLE `department_subtask_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtask_id` (`subtask_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_tasks`
--
ALTER TABLE `department_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_from_dept` (`from_department_id`),
  ADD KEY `fk_to_dept` (`to_department_id`),
  ADD KEY `fk_assigned_by` (`assigned_by`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `department_task_assignees`
--
ALTER TABLE `department_task_assignees`
  ADD PRIMARY KEY (`task_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_task_categories`
--
ALTER TABLE `department_task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `department_task_comments`
--
ALTER TABLE `department_task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtask_id` (`subtask_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_task_followers`
--
ALTER TABLE `department_task_followers`
  ADD PRIMARY KEY (`task_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_task_related_departments`
--
ALTER TABLE `department_task_related_departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Chỉ mục cho bảng `department_task_related_users`
--
ALTER TABLE `department_task_related_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_task_id` (`department_task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `department_task_responsibles`
--
ALTER TABLE `department_task_responsibles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_task_id` (`department_task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `project_groups`
--
ALTER TABLE `project_groups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_created_by` (`created_by`),
  ADD KEY `fk_project_group` (`project_group`),
  ADD KEY `fk_category` (`category`);

--
-- Chỉ mục cho bảng `task_reports`
--
ALTER TABLE `task_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `task_responsible`
--
ALTER TABLE `task_responsible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `task_results`
--
ALTER TABLE `task_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Chỉ mục cho bảng `task_supervisors`
--
ALTER TABLE `task_supervisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `department_subtasks`
--
ALTER TABLE `department_subtasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `department_subtask_comments`
--
ALTER TABLE `department_subtask_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `department_subtask_followers`
--
ALTER TABLE `department_subtask_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `department_subtask_reports`
--
ALTER TABLE `department_subtask_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `department_tasks`
--
ALTER TABLE `department_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `department_task_categories`
--
ALTER TABLE `department_task_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `department_task_comments`
--
ALTER TABLE `department_task_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `department_task_related_departments`
--
ALTER TABLE `department_task_related_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `department_task_related_users`
--
ALTER TABLE `department_task_related_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `department_task_responsibles`
--
ALTER TABLE `department_task_responsibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT cho bảng `project_groups`
--
ALTER TABLE `project_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT cho bảng `task_reports`
--
ALTER TABLE `task_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho bảng `task_responsible`
--
ALTER TABLE `task_responsible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `task_results`
--
ALTER TABLE `task_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT cho bảng `task_supervisors`
--
ALTER TABLE `task_supervisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`project_group_id`) REFERENCES `project_groups` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_subtasks`
--
ALTER TABLE `department_subtasks`
  ADD CONSTRAINT `fk_assignee` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task` FOREIGN KEY (`task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_subtask_comments`
--
ALTER TABLE `department_subtask_comments`
  ADD CONSTRAINT `department_subtask_comments_ibfk_1` FOREIGN KEY (`subtask_id`) REFERENCES `department_subtasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_subtask_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `department_subtask_followers`
--
ALTER TABLE `department_subtask_followers`
  ADD CONSTRAINT `department_subtask_followers_ibfk_1` FOREIGN KEY (`subtask_id`) REFERENCES `department_subtasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_subtask_followers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_subtask_reports`
--
ALTER TABLE `department_subtask_reports`
  ADD CONSTRAINT `department_subtask_reports_ibfk_1` FOREIGN KEY (`subtask_id`) REFERENCES `department_subtasks` (`id`),
  ADD CONSTRAINT `department_subtask_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `department_tasks`
--
ALTER TABLE `department_tasks`
  ADD CONSTRAINT `department_tasks_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `department_tasks_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `department_task_categories` (`id`),
  ADD CONSTRAINT `fk_assigned_by` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_from_dept` FOREIGN KEY (`from_department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_to_dept` FOREIGN KEY (`to_department_id`) REFERENCES `departments` (`id`);

--
-- Các ràng buộc cho bảng `department_task_assignees`
--
ALTER TABLE `department_task_assignees`
  ADD CONSTRAINT `department_task_assignees_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_assignees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_task_comments`
--
ALTER TABLE `department_task_comments`
  ADD CONSTRAINT `department_task_comments_ibfk_1` FOREIGN KEY (`subtask_id`) REFERENCES `department_subtasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_task_followers`
--
ALTER TABLE `department_task_followers`
  ADD CONSTRAINT `department_task_followers_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_followers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_task_related_departments`
--
ALTER TABLE `department_task_related_departments`
  ADD CONSTRAINT `department_task_related_departments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_related_departments_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_task_related_users`
--
ALTER TABLE `department_task_related_users`
  ADD CONSTRAINT `department_task_related_users_ibfk_1` FOREIGN KEY (`department_task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_related_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department_task_responsibles`
--
ALTER TABLE `department_task_responsibles`
  ADD CONSTRAINT `department_task_responsibles_ibfk_1` FOREIGN KEY (`department_task_id`) REFERENCES `department_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_task_responsibles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_project_group` FOREIGN KEY (`project_group`) REFERENCES `project_groups` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `task_responsible`
--
ALTER TABLE `task_responsible`
  ADD CONSTRAINT `task_responsible_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_responsible_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `task_supervisors`
--
ALTER TABLE `task_supervisors`
  ADD CONSTRAINT `task_supervisors_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_supervisors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 19 2025 г., 00:39
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `usacitizenguide`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Тип уведомления (например, new_testimonial)',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int UNSIGNED DEFAULT NULL COMMENT 'ID связанной сущности',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `type`, `message`, `reference_id`, `is_read`, `created_at`) VALUES
(1, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 7, 0, '2025-12-16 18:59:52'),
(2, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 8, 0, '2025-12-16 18:59:52'),
(3, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 1/5', 9, 0, '2025-12-16 19:00:05'),
(4, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 1/5', 10, 0, '2025-12-16 19:00:05'),
(5, 'new_testimonial', 'Новый отзыв от пользователя Вероничечка с рейтингом 3/5', 13, 0, '2025-12-16 19:11:02'),
(6, 'new_testimonial', 'Новый отзыв от пользователя Вероничечка с рейтингом 3/5', 14, 0, '2025-12-16 19:11:02'),
(7, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 15, 0, '2025-12-16 19:40:20'),
(8, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 16, 0, '2025-12-16 19:40:20'),
(9, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 19, 0, '2025-12-16 19:41:00'),
(10, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 20, 0, '2025-12-16 19:41:00'),
(11, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 29, 0, '2025-12-16 19:55:43'),
(12, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 30, 0, '2025-12-16 19:55:43'),
(13, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 31, 0, '2025-12-16 19:56:55'),
(14, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 32, 0, '2025-12-16 19:56:55'),
(15, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 35, 0, '2025-12-16 19:58:06'),
(16, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 36, 0, '2025-12-16 19:58:06'),
(17, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 37, 0, '2025-12-16 19:58:22'),
(18, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 38, 0, '2025-12-16 19:58:22'),
(19, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 39, 0, '2025-12-16 20:01:29'),
(20, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 40, 0, '2025-12-16 20:01:29'),
(21, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 41, 0, '2025-12-16 20:39:26'),
(22, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 42, 0, '2025-12-16 20:39:26'),
(23, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 43, 0, '2025-12-16 20:40:27'),
(24, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 44, 0, '2025-12-16 20:40:27'),
(25, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 45, 0, '2025-12-16 20:46:48'),
(26, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 1/5', 46, 0, '2025-12-17 20:24:00'),
(27, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 47, 0, '2025-12-17 20:24:16'),
(28, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 76, 0, '2025-12-17 20:46:04'),
(29, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 77, 0, '2025-12-17 20:46:04'),
(30, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 1/5', 78, 0, '2025-12-17 20:48:18'),
(31, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 79, 0, '2025-12-17 20:48:30'),
(32, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 80, 0, '2025-12-17 20:49:04'),
(33, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 2/5', 81, 0, '2025-12-17 20:50:08'),
(34, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 82, 0, '2025-12-17 21:02:30'),
(35, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 83, 0, '2025-12-17 21:02:30'),
(36, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 84, 0, '2025-12-17 21:02:50'),
(37, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 85, 0, '2025-12-17 21:02:50'),
(38, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 3/5', 86, 0, '2025-12-17 21:04:19'),
(39, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 4/5', 87, 0, '2025-12-17 21:04:38'),
(40, 'new_testimonial', 'Новый отзыв от пользователя Артём с рейтингом 5/5', 88, 0, '2025-12-17 21:31:00'),
(41, 'new_testimonial', 'Новый отзыв от пользователя Андрей с рейтингом 1/5', 89, 0, '2025-12-17 21:33:25');

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `image_url`, `category_id`, `created_at`) VALUES
(48, 'Как выбрать тип визы в США и не ошибиться', '--1766009838-1833', 'Одна из самых частых причин отказа — неправильно выбранный тип визы. Туристическая, студенческая, рабочая или иммиграционная виза имеют разные требования и цели.\r\nПеред подачей важно четко понимать, зачем вы едете в США и какие документы подтверждают вашу цель. Ошибка на этом этапе может стоить не только отказа, но и проблем с будущими заявками.', 'uploads/articles/article_1766009838_3767.jpeg', NULL, '2025-12-17 22:17:18'),
(49, 'Почему США так внимательно проверяют визовых заявителей', '--1766009891-7954', 'Американская визовая система строится на принципе презумпции иммиграционных намерений: офицер исходит из того, что заявитель может остаться в стране нелегально.\r\nЗадача заявителя — доказать обратное: наличие стабильной работы, дохода, семьи и связей с родной страной. Понимание этой логики значительно повышает шансы на одобрение визы.', 'uploads/articles/article_1766009891_2112.jpeg', NULL, '2025-12-17 22:18:11');

-- --------------------------------------------------------

--
-- Структура таблицы `cases`
--

CREATE TABLE `cases` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `status` enum('Not started','Collecting documents','Ready to file','Filed','Biometrics scheduled','Interview','Oath','Done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not started',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cases`
--

INSERT INTO `cases` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Done', '2025-12-14 23:07:57', '2025-12-18 05:09:27'),
(2, 1, 'Ready to file', '2025-12-16 01:59:19', '2025-12-18 05:09:34'),
(3, 9, 'Not started', '2025-12-18 17:54:40', '2025-12-18 17:54:40');

-- --------------------------------------------------------

--
-- Структура таблицы `case_documents`
--

CREATE TABLE `case_documents` (
  `id` int UNSIGNED NOT NULL,
  `case_id` int UNSIGNED NOT NULL,
  `stage` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','under_review','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `case_documents`
--

INSERT INTO `case_documents` (`id`, `case_id`, `stage`, `title`, `file_path`, `uploaded_at`, `status`, `admin_comment`) VALUES
(1, 1, 'Collecting documents', 'фйв', 'uploads/1765753715________________________2025-12-15_040834099.png', '2025-12-14 23:08:35', 'pending', NULL),
(2, 2, 'Collecting documents', 'Резюме с HH.ru', 'uploads/1765850448___________________-__________-______________________.pdf', '2025-12-16 02:00:48', 'pending', NULL),
(3, 2, 'Collecting documents', '23', 'uploads/1765888188_ChatGPT_Image_15_______._2025___.__03_14_59.png', '2025-12-16 12:29:48', 'pending', NULL),
(4, 2, 'Filed', 'уц', 'uploads/1765888438___________________-__________-______________________.pdf', '2025-12-16 12:33:58', 'pending', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `checklists`
--

CREATE TABLE `checklists` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `steps` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `case_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `checklists`
--

INSERT INTO `checklists` (`id`, `user_id`, `title`, `steps`, `created_at`, `case_id`) VALUES
(1, 2, 'ДЕФолт', 'фыв', '2025-12-14 23:08:17', NULL),
(2, 1, 'f', 'f', '2025-12-16 01:59:05', NULL),
(3, 1, 'ad', 'sdf', '2025-12-16 12:29:12', NULL),
(4, 1, 'ad', 'sdf', '2025-12-16 12:29:15', NULL),
(5, 1, 'фыв', 'фыв', '2025-12-16 12:31:02', NULL),
(6, 1, 'фывфыв', '123', '2025-12-16 12:32:30', NULL),
(7, 1, 'вы', 'ва', '2025-12-16 12:34:16', NULL),
(8, 1, 'Гражданство на основе военной службы', 'Шаг1:фуа\r\nШаг2:пукщпшоу\r\nШаг3:а43п', '2025-12-16 21:05:46', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE `faq` (
  `id` int UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(6, 'Гарантирует ли MyUSAPassport получение визы в США?', 'Нет. Ни один сервис не может гарантировать выдачу визы — решение всегда принимает визовый офицер.\r\nMyUSAPassport помогает подготовить документы, избежать типичных ошибок и повысить шансы на одобрение, но не влияет на итоговое решение консульства.'),
(7, 'Могу ли я подать документы, если ранее был отказ?', 'Да. Отказ не означает пожизненный запрет на получение визы.\r\nВажно понять причину предыдущего отказа, устранить слабые места в анкете и подать заявку повторно с корректной стратегией. В ряде случаев повторная подача бывает успешной.');

-- --------------------------------------------------------

--
-- Структура таблицы `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` tinyint UNSIGNED DEFAULT NULL COMMENT 'Рейтинг от 1 до 5',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'Статус модерации',
  `admin_notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Примечания администратора'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `inquiries`
--

INSERT INTO `inquiries` (`id`, `user_id`, `message`, `created_at`, `rating`, `status`, `admin_notes`) VALUES
(1, NULL, 'sdf', '2025-12-14 21:36:02', NULL, 'pending', NULL),
(2, 1, 'GHbdtn', '2025-12-16 12:57:19', NULL, 'pending', NULL),
(3, 1, 'фыв', '2025-12-16 12:57:24', NULL, 'pending', NULL),
(4, 1, 'ф21', '2025-12-16 12:57:28', NULL, 'pending', NULL),
(5, 1, 'норм', '2025-12-16 18:59:46', NULL, 'pending', NULL),
(6, 1, 'норм', '2025-12-16 18:59:46', NULL, 'pending', NULL),
(7, 1, 'Рейтинг: 4/5\n\nномр', '2025-12-16 18:59:52', NULL, 'pending', NULL),
(8, 1, 'Рейтинг: 4/5\n\nномр', '2025-12-16 18:59:52', NULL, 'pending', NULL),
(9, 1, 'Рейтинг: 1/5\n\nа', '2025-12-16 19:00:05', NULL, 'pending', NULL),
(10, 1, 'Рейтинг: 1/5\n\nа', '2025-12-16 19:00:05', NULL, 'pending', NULL),
(11, 1, 'НЕТ', '2025-12-16 19:00:17', NULL, 'pending', NULL),
(12, 1, 'НЕТ', '2025-12-16 19:00:17', NULL, 'pending', NULL),
(13, 6, 'Рейтинг: 3/5\n\nМне дали гражданство!!! Но Палестины...', '2025-12-16 19:11:02', NULL, 'pending', NULL),
(14, 6, 'Рейтинг: 3/5\n\nМне дали гражданство!!! Но Палестины...', '2025-12-16 19:11:02', NULL, 'pending', NULL),
(15, 1, 'Рейтинг: 4/5\n\nУрааа пиздец', '2025-12-16 19:40:20', NULL, 'pending', NULL),
(16, 1, 'Рейтинг: 4/5\n\nУрааа пиздец', '2025-12-16 19:40:20', NULL, 'pending', NULL),
(17, 1, 'м ага ага', '2025-12-16 19:40:45', NULL, 'pending', NULL),
(18, 1, 'м ага ага', '2025-12-16 19:40:45', NULL, 'pending', NULL),
(19, 1, 'Рейтинг: 5/5\n\nопа', '2025-12-16 19:41:00', NULL, 'pending', NULL),
(20, 1, 'Рейтинг: 5/5\n\nопа', '2025-12-16 19:41:00', NULL, 'pending', NULL),
(21, 1, 'хихихи', '2025-12-16 19:45:08', NULL, 'pending', NULL),
(22, 1, 'хихихи', '2025-12-16 19:45:08', NULL, 'pending', NULL),
(23, 1, 'GHbdtn', '2025-12-16 19:46:19', NULL, 'pending', NULL),
(24, 1, 'GHbdtn', '2025-12-16 19:46:19', NULL, 'pending', NULL),
(25, 1, 'Привет', '2025-12-16 19:51:10', NULL, 'pending', NULL),
(26, 1, 'Привет', '2025-12-16 19:51:10', NULL, 'pending', NULL),
(27, 1, 'ПРивет', '2025-12-16 19:53:32', NULL, 'pending', NULL),
(28, 1, 'ПРивет', '2025-12-16 19:53:32', NULL, 'pending', NULL),
(29, 1, 'Рейтинг: 4/5\n\nПРивет', '2025-12-16 19:55:43', NULL, 'pending', NULL),
(30, 1, 'Рейтинг: 4/5\n\nПРивет', '2025-12-16 19:55:43', NULL, 'pending', NULL),
(31, 1, 'Рейтинг: 2/5\n\nЭй сучка', '2025-12-16 19:56:55', NULL, 'pending', NULL),
(32, 1, 'Рейтинг: 2/5\n\nЭй сучка', '2025-12-16 19:56:55', NULL, 'pending', NULL),
(33, 1, 'Hi', '2025-12-16 19:57:52', NULL, 'pending', NULL),
(34, 1, 'Hi', '2025-12-16 19:57:52', NULL, 'pending', NULL),
(35, 1, 'Рейтинг: 3/5\n\nПривет', '2025-12-16 19:58:06', NULL, 'pending', NULL),
(36, 1, 'Рейтинг: 3/5\n\nПривет', '2025-12-16 19:58:06', NULL, 'pending', NULL),
(37, 1, 'Рейтинг: 5/5\n\nАЛЁЁЁ', '2025-12-16 19:58:22', NULL, 'pending', NULL),
(38, 1, 'Рейтинг: 5/5\n\nАЛЁЁЁ', '2025-12-16 19:58:22', NULL, 'pending', NULL),
(39, 1, 'Рейтинг: 3/5\n\nХЕЛП СУКА', '2025-12-16 20:01:29', NULL, 'pending', NULL),
(40, 1, 'Рейтинг: 3/5\n\nХЕЛП СУКА', '2025-12-16 20:01:29', NULL, 'pending', NULL),
(41, 1, 'Рейтинг: 5/5\n\nПривет даун', '2025-12-16 20:39:26', NULL, 'pending', NULL),
(42, 1, 'Рейтинг: 5/5\n\nПривет даун', '2025-12-16 20:39:26', NULL, 'pending', NULL),
(43, 1, 'Рейтинг: 3/5\n\nfe[f[ef[ef[ef', '2025-12-16 20:40:27', NULL, 'pending', NULL),
(44, 1, 'Рейтинг: 3/5\n\nfe[f[ef[ef[ef', '2025-12-16 20:40:27', NULL, 'pending', NULL),
(45, 1, 'Рейтинг: 4/5\n\nфывйцузцозщйцлзщ', '2025-12-16 20:46:48', NULL, 'pending', NULL),
(46, 1, 'Рейтинг: 1/5\n\nНу и хуйня', '2025-12-17 20:24:00', NULL, 'pending', NULL),
(47, 1, 'Рейтинг: 2/5\n\nНу и хуйня', '2025-12-17 20:24:16', NULL, 'pending', NULL),
(48, 1, 'Рейтинг: 1/5\n\nНу и хуйня', '2025-12-17 20:39:52', NULL, 'pending', NULL),
(49, 1, 'Рейтинг: 1/5\n\nНу и хуйня', '2025-12-17 20:39:52', NULL, 'pending', NULL),
(50, 1, 'Рейтинг: 1/5\n\nНу и хуйня', '2025-12-17 20:39:54', NULL, 'pending', NULL),
(51, 1, 'Рейтинг: 1/5\n\nНу и хуйня', '2025-12-17 20:39:54', NULL, 'pending', NULL),
(52, 1, 'Рейтинг: 1/5\n\nЗАЛУПА', '2025-12-17 20:40:11', NULL, 'pending', NULL),
(53, 1, 'Рейтинг: 1/5\n\nЗАЛУПА', '2025-12-17 20:40:11', NULL, 'pending', NULL),
(54, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:46', NULL, 'pending', NULL),
(55, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:46', NULL, 'pending', NULL),
(56, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(57, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(58, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(59, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(60, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(61, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:48', NULL, 'pending', NULL),
(62, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(63, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(64, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(65, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(66, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(67, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(68, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(69, 1, 'Рейтинг: 1/5\n\nЗАЛУПЕНЬ', '2025-12-17 20:40:49', NULL, 'pending', NULL),
(70, 1, 'Рейтинг: 1/5\n\nПолная залупа', '2025-12-17 20:44:42', NULL, 'pending', NULL),
(71, 1, 'Рейтинг: 1/5\n\nПолная залупа', '2025-12-17 20:44:42', NULL, 'pending', NULL),
(72, 1, 'Рейтинг: 1/5\n\nПолная залупа', '2025-12-17 20:44:44', NULL, 'pending', NULL),
(73, 1, 'Рейтинг: 1/5\n\nПолная залупа', '2025-12-17 20:44:44', NULL, 'pending', NULL),
(74, 1, 'Рейтинг: 4/5\n\nФЫВФЫВФЫВФЫВ', '2025-12-17 20:45:14', NULL, 'pending', NULL),
(75, 1, 'Рейтинг: 4/5\n\nФЫВФЫВФЫВФЫВ', '2025-12-17 20:45:15', NULL, 'pending', NULL),
(76, 1, 'Рейтинг: 2/5\n\nФЫВФЫВФАДЖЛЫАЖЛЫА', '2025-12-17 20:46:04', NULL, 'pending', NULL),
(77, 1, 'Рейтинг: 2/5\n\nФЫВФЫВФАДЖЛЫАЖЛЫА', '2025-12-17 20:46:04', NULL, 'pending', NULL),
(78, 1, 'Рейтинг: 1/5\n\nСЛЫШЬ ШЛЮХА - РАБОТАЙ', '2025-12-17 20:48:18', NULL, 'pending', NULL),
(79, 1, 'Рейтинг: 2/5\n\nСЛЫШЬ ШЛЮХААА', '2025-12-17 20:48:30', NULL, 'pending', NULL),
(80, 1, 'Рейтинг: 4/5\n\nХХИХИХИХИХИХЫЖВДЛЫВОАДЫВДАЛЫОВЛЖАЛЫЖДФВАДЛОЩ21Г301298309123', '2025-12-17 20:49:04', NULL, 'pending', NULL),
(81, 1, 'Рейтинг: 2/5\n\nизи  изи камон камон', '2025-12-17 20:50:08', NULL, 'pending', NULL),
(82, 1, 'Рейтинг: 5/5\n\nопа', '2025-12-17 21:02:30', NULL, 'pending', NULL),
(83, 1, 'Рейтинг: 5/5\n\nопа', '2025-12-17 21:02:30', NULL, 'pending', NULL),
(84, 1, 'Рейтинг: 3/5\n\nДА БЛЯТЬ', '2025-12-17 21:02:50', NULL, 'pending', NULL),
(85, 1, 'Рейтинг: 3/5\n\nДА БЛЯТЬ', '2025-12-17 21:02:50', NULL, 'pending', NULL),
(86, 1, 'Рейтинг: 3/5\n\n123321', '2025-12-17 21:04:19', NULL, 'pending', NULL),
(87, 1, 'Рейтинг: 4/5\n\n34234', '2025-12-17 21:04:38', NULL, 'pending', NULL),
(88, 1, 'Рейтинг: 5/5\n\nШикарный сервис! Дали гражданство за месяц! Теперь я официально американец!', '2025-12-17 21:31:00', NULL, 'pending', NULL),
(89, 7, 'Рейтинг: 1/5\n\nЯ ПАТРИОТ! НЕ НУЖНА НАМ ЭТА АМЕРИКА! СЛАВА РОССИИ!!!!!!', '2025-12-17 21:33:25', NULL, 'pending', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migration_cases`
--

CREATE TABLE `migration_cases` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'naturalization, greencard, marriage, investment, military, employment',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','completed','paused','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `image_url`, `created_at`) VALUES
(15, 'Администрация США ужесточила визовый контроль для заявителей из зон повышенного риска', '--1766009094-6860', 'Власти США объявили о введении дополнительных мер проверки для заявителей на неиммиграционные визы из регионов, признанных зонами повышенного миграционного и криминального риска. Новые правила включают расширенные интервью, проверку цифрового следа и дополнительную биометрическую идентификацию.\r\nПо заявлению Госдепартамента, меры направлены на повышение национальной безопасности и не отменяют возможность легального въезда для добросовестных заявителей.', 'uploads/news/news_1766009094_7746.jpg', '2025-12-17 22:04:54'),
(16, 'США временно приостановили выдачу виз лицам, связанным с пиратской деятельностью', '--1766009229-1665', 'В рамках международного сотрудничества по борьбе с морским пиратством США ввели временные ограничения на выдачу виз лицам, подозреваемым в участии в пиратских группировках у берегов Восточной Африки.\r\nРешение принято после серии совместных расследований с Интерполом и военно-морскими силами союзников. Ограничения не затрагивают гражданских лиц и законных мигрантов.', 'uploads/news/news_1766009229_8064.jpg', '2025-12-17 22:07:09'),
(17, 'Сроки рассмотрения туристических виз в США увеличились', '--1766009377-5342', 'Госдепартамент США сообщил о росте сроков обработки заявлений на туристические визы (B1/B2) в ряде консульств. Причиной названы высокий сезон путешествий и увеличение количества заявок.\r\nЗаявителям рекомендуется подавать документы заранее и тщательно проверять их корректность перед подачей.', 'uploads/news/news_1766009377_4675.jpg', '2025-12-17 22:09:37');

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(1, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:02:37'),
(2, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:27:49'),
(3, 2, 'Статус вашего кейса изменён администратором на: Done', '2025-12-16 02:27:54'),
(4, 2, 'Статус вашего кейса изменён администратором на: Done', '2025-12-16 02:27:56'),
(5, 2, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:28:24'),
(6, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:32:25'),
(7, 2, 'Статус вашего кейса изменён администратором на: Interview', '2025-12-16 02:32:29'),
(8, 2, 'Статус вашего кейса изменён администратором на: Interview', '2025-12-16 02:33:02'),
(9, 2, 'Статус вашего кейса изменён администратором на: Not started', '2025-12-16 02:33:04'),
(10, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:33:06'),
(11, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:33:57'),
(12, 2, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:36:04'),
(13, 2, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:36:05'),
(14, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:36:13'),
(15, 2, 'Статус вашего кейса изменён администратором на: Filed', '2025-12-16 02:37:01'),
(16, 2, 'Статус вашего кейса изменён администратором на: Interview', '2025-12-16 02:38:09'),
(17, 2, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:38:27'),
(18, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:39:47'),
(19, 2, 'Статус вашего кейса изменён администратором на: Biometrics scheduled', '2025-12-16 02:40:41'),
(20, 2, 'Статус вашего кейса изменён администратором на: Oath', '2025-12-16 02:40:45'),
(21, 1, 'Статус вашего кейса изменён администратором на: Filed', '2025-12-16 02:40:49'),
(22, 1, 'Статус вашего кейса изменён администратором на: Oath', '2025-12-16 02:40:52'),
(23, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:40:53'),
(24, 2, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 02:41:35'),
(25, 2, 'Статус вашего кейса изменён администратором на: Filed', '2025-12-16 02:41:37'),
(26, 2, 'Статус вашего кейса изменён администратором на: Filed', '2025-12-16 02:41:41'),
(27, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:41:42'),
(28, 1, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 02:54:51'),
(29, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 12:30:06'),
(30, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 12:30:07'),
(31, 1, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 12:34:06'),
(32, 1, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 12:34:09'),
(33, 1, 'Статус вашего кейса изменён администратором на: Biometrics scheduled', '2025-12-16 12:34:11'),
(34, 1, 'Статус вашего кейса изменён администратором на: Collecting documents', '2025-12-16 12:54:05'),
(35, 1, 'Статус вашего кейса изменён администратором на: Biometrics scheduled', '2025-12-16 12:57:37'),
(36, 1, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 13:27:47'),
(37, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 13:27:48'),
(38, 2, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-16 13:27:49'),
(39, 2, 'Статус вашего кейса изменён администратором на: Not started', '2025-12-16 13:27:50'),
(40, 2, 'Статус вашего кейса изменён администратором на: Done', '2025-12-18 05:09:27'),
(41, 1, 'Статус вашего кейса изменён администратором на: Done', '2025-12-18 05:09:28'),
(42, 1, 'Статус вашего кейса изменён администратором на: Done', '2025-12-18 05:09:29'),
(43, 1, 'Статус вашего кейса изменён администратором на: Done', '2025-12-18 05:09:29'),
(44, 1, 'Статус вашего кейса изменён администратором на: Done', '2025-12-18 05:09:29'),
(45, 1, 'Статус вашего кейса изменён администратором на: Ready to file', '2025-12-18 05:09:34');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(1, 1, '7313b54d40ab4f5deea41c14c52c7703', '2025-12-16 23:12:32', '2025-12-16 19:12:32');

-- --------------------------------------------------------

--
-- Структура таблицы `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int UNSIGNED NOT NULL,
  `inquiry_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(1) DEFAULT '0' COMMENT 'Избранный отзыв (для показа на главной)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','approved','featured') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `testimonials`
--

INSERT INTO `testimonials` (`id`, `inquiry_id`, `user_id`, `user_name`, `rating`, `content`, `is_featured`, `created_at`, `status`) VALUES
(40, 88, 1, 'Артём', 5, 'Шикарный сервис! Дали гражданство за месяц! Теперь я официально американец!', 0, '2025-12-17 21:31:00', 'approved'),
(41, 89, 7, 'Андрей', 1, 'Я ПАТРИОТ! НЕ НУЖНА НАМ ЭТА АМЕРИКА! СЛАВА РОССИИ!!!!!!', 0, '2025-12-17 21:33:25', 'approved');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path to user avatar image',
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Артём', 'asd@gmail.com', 'uploads/avatars/avatar_1_1765913430.jpg', '$2y$10$ybDpXew3/rXqG/KAzms8p.9go6ArtiLL/EPnGKUWIVHtjMDahs.2e', 'admin', '2025-12-14 21:48:30'),
(2, 'Иван', 'Ivan@gmail.com', NULL, '$2y$10$3lyrohMs1Ln5qJLDbGIRZe1AjrfHyDOHRzN2VZL0MWVmX3TedWSza', 'admin', '2025-12-14 23:04:58'),
(3, 'z', 'z@gmail.com', NULL, '$2y$10$7MeRBJdl7ywGwTeZTb1z5uIrSOmNdS4XdtgUMg9kcUS2mLRdyzkl2', 'user', '2025-12-16 13:33:02'),
(4, 'x', 'x@gmail.com', NULL, '$2y$10$fl.A.hf1znNNSEPZyvGdguiL2Vk1i7Q9sF9ga8dZC.J0vcoOSpUr6', 'user', '2025-12-16 13:33:49'),
(5, 'c', 'c@gmail.com', NULL, '$2y$10$z4VocJ.13cJWmm4j8WFLmuayphvj0.8YBML5dhb5VpjRy4ZYvHqca', 'user', '2025-12-16 13:34:04'),
(6, 'Вероничечка', 'nika@gmail.com', 'uploads/avatars/avatar_6_1765912227.gif', '$2y$10$f.P5RtLaODqsutjHKVbtau.Xsiqlnr0GJMP1WPYa2cpgamPGGINBO', 'user', '2025-12-16 19:06:11'),
(7, 'Андрей', 'andrew2002@gmail.com', 'uploads/avatars/avatar_7_1766007176.png', '$2y$10$9IeBHLPsJ3xfPMFAeDyZee3/.E75ipV/kC8k8RrOzzcv3EpHaf0Rm', 'user', '2025-12-17 21:31:41'),
(8, 'жЫЫрный', 'zhirniy@egor.vo', NULL, '$2y$10$uuqL3GR9q9CVoX5qCLziYu6EMZXoR9V8MdFNgzdOGV2bBhSWFB0oa', 'user', '2025-12-18 05:50:18'),
(9, 'Ника', 'ketkaveronika@gmail.com', NULL, '$2y$10$5jsedTcjO2Qt.TrQrKs6SOAwC5whexjebURtkcRZvqvDrcj//oz8i', 'user', '2025-12-18 17:53:38');

-- --------------------------------------------------------

--
-- Структура таблицы `wizard_responses`
--

CREATE TABLE `wizard_responses` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `data_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wizard_responses`
--

INSERT INTO `wizard_responses` (`id`, `user_id`, `data_json`, `result`, `created_at`) VALUES
(1, 1, '{\"full_name\":\"Артём\",\"age\":\"19\",\"current_citizenship\":\"Россия\",\"years_in_usa\":\"0\",\"outside_usa_details\":\"\",\"status\":\"out_of_status\",\"status_basis\":\"брак\",\"official_job\":\"no\",\"travel_details\":\"\",\"serious_crime\":\"no\",\"crime_details\":\"\",\"file_taxes\":\"no\",\"tax_debts\":\"no\",\"marital_status\":\"single\",\"married_to_citizen\":\"no\",\"english_level\":\"intermediate\",\"ready_for_english_test\":\"yes\",\"long_trips\":\"no\",\"total_time_outside\":\"more_than_12_months\"}', 'not_eligible', '2025-12-17 22:24:55'),
(2, 1, '{\"full_name\":\"Артём\",\"age\":\"19\",\"current_citizenship\":\"Россия\",\"years_in_usa\":\"0\",\"outside_usa_details\":\"\",\"status\":\"out_of_status\",\"status_basis\":\"брак\",\"official_job\":\"no\",\"travel_details\":\"\",\"serious_crime\":\"no\",\"crime_details\":\"\",\"file_taxes\":\"no\",\"tax_debts\":\"no\",\"marital_status\":\"single\",\"married_to_citizen\":\"no\",\"english_level\":\"intermediate\",\"ready_for_english_test\":\"yes\",\"long_trips\":\"no\",\"total_time_outside\":\"more_than_12_months\"}', 'not_eligible', '2025-12-17 22:36:00'),
(3, 1, '{\"full_name\":\"Артём\",\"age\":\"19\",\"current_citizenship\":\"Россия\",\"years_in_usa\":\"5\",\"outside_usa_details\":\"Да\",\"status\":\"visa\",\"status_basis\":\"работа\",\"official_job\":\"yes\",\"travel_details\":\"Нет\",\"serious_crime\":\"no\",\"crime_details\":\"\",\"file_taxes\":\"yes\",\"tax_debts\":\"no\",\"marital_status\":\"single\",\"married_to_citizen\":\"no\",\"english_level\":\"intermediate\",\"ready_for_english_test\":\"yes\",\"long_trips\":\"no\",\"total_time_outside\":\"less_than_6_months\"}', 'eligible', '2025-12-17 22:36:43'),
(4, 1, '{\"current_location\":\"outside_usa\",\"has_greencard\":\"no\",\"marital_status\":\"single\",\"spouse_us_citizen\":\"no\",\"has_education\":\"no\",\"has_specialty\":\"no\",\"can_invest\":\"no\",\"military_ready\":\"no\",\"age\":\"18-25\",\"english_level\":\"intermediate\",\"job_offer\":\"no\",\"email\":\"\"}', 'Лотерея Green Card', '2025-12-18 21:24:18'),
(5, 1, '{\"current_location\":\"outside_usa\",\"has_greencard\":\"yes\",\"marital_status\":\"single\",\"spouse_us_citizen\":\"no\",\"has_education\":\"yes\",\"has_specialty\":\"yes\",\"can_invest\":\"no\",\"military_ready\":\"yes\",\"age\":\"18-25\",\"english_level\":\"intermediate\",\"job_offer\":\"no\",\"email\":\"\"}', 'Натурализация', '2025-12-18 21:24:58');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `case_documents`
--
ALTER TABLE `case_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `checklists`
--
ALTER TABLE `checklists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `migration_cases`
--
ALTER TABLE `migration_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiry_id` (`inquiry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `wizard_responses`
--
ALTER TABLE `wizard_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `case_documents`
--
ALTER TABLE `case_documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `checklists`
--
ALTER TABLE `checklists`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT для таблицы `migration_cases`
--
ALTER TABLE `migration_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `wizard_responses`
--
ALTER TABLE `wizard_responses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `case_documents`
--
ALTER TABLE `case_documents`
  ADD CONSTRAINT `case_documents_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `checklists`
--
ALTER TABLE `checklists`
  ADD CONSTRAINT `checklists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `migration_cases`
--
ALTER TABLE `migration_cases`
  ADD CONSTRAINT `migration_cases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `testimonials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `wizard_responses`
--
ALTER TABLE `wizard_responses`
  ADD CONSTRAINT `wizard_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

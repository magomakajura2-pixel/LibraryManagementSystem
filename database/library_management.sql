-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2026 at 03:43 PM
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
-- Database: `library_management`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_borrow_book` (IN `p_book_id` INT UNSIGNED, IN `p_member_id` INT UNSIGNED, IN `p_librarian_id` INT UNSIGNED, IN `p_loan_days` INT)   BEGIN
    DECLARE v_available INT; DECLARE v_status VARCHAR(20);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN ROLLBACK; RESIGNAL; END;
    START TRANSACTION;
        SELECT available_copies INTO v_available FROM books WHERE book_id = p_book_id FOR UPDATE;
        SELECT status INTO v_status FROM members WHERE member_id = p_member_id;
        IF v_available IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Book does not exist.';
        END IF;
        IF v_available < 1 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No copies available to borrow.';
        END IF;
        IF v_status <> 'active' THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Member is not active.';
        END IF;
        INSERT INTO borrowings (book_id, member_id, librarian_id, borrow_date, due_date)
        VALUES (p_book_id, p_member_id, p_librarian_id, CURRENT_DATE,
                DATE_ADD(CURRENT_DATE, INTERVAL COALESCE(p_loan_days,14) DAY));
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mark_overdue` ()   BEGIN
    UPDATE borrowings SET status = 'overdue'
     WHERE status = 'borrowed' AND due_date < CURRENT_DATE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_return_book` (IN `p_borrowing_id` INT UNSIGNED, IN `p_condition` ENUM('good','damaged','lost'), IN `p_received_by` INT UNSIGNED)   BEGIN
    DECLARE v_exists INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN ROLLBACK; RESIGNAL; END;
    START TRANSACTION;
        SELECT COUNT(*) INTO v_exists FROM borrowings
         WHERE borrowing_id = p_borrowing_id AND status IN ('borrowed','overdue');
        IF v_exists = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No open loan found for that borrowing id.';
        END IF;
        INSERT INTO returns (borrowing_id, return_date, book_condition, received_by)
        VALUES (p_borrowing_id, CURRENT_DATE, COALESCE(p_condition,'good'), p_received_by);
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search_books` (IN `p_term` VARCHAR(255))   BEGIN
    SELECT book_id, isbn, title, author, available_copies, status
      FROM books
     WHERE title LIKE CONCAT('%', p_term, '%')
        OR author LIKE CONCAT('%', p_term, '%')
        OR isbn  LIKE CONCAT('%', p_term, '%')
     ORDER BY title;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `actor` varchar(150) NOT NULL,
  `action` varchar(20) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `record_id` varchar(64) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`log_id`, `actor`, `action`, `table_name`, `record_id`, `details`, `created_at`) VALUES
(1, 'root@localhost', 'INSERT', 'books', '1', 'Added: The C Programming Language', '2026-07-07 13:35:21'),
(2, 'root@localhost', 'INSERT', 'books', '2', 'Added: Introduction to Algorithms', '2026-07-07 13:35:21'),
(3, 'root@localhost', 'INSERT', 'books', '3', 'Added: Head First SQL', '2026-07-07 13:35:21'),
(4, 'root@localhost', 'INSERT', 'books', '4', 'Added: Concrete Mathematics', '2026-07-07 13:35:21'),
(5, 'root@localhost', 'INSERT', 'books', '5', 'Added: Pride and Prejudice', '2026-07-07 13:35:21'),
(6, 'root@localhost', 'INSERT', 'books', '6', 'Added: The Catcher in the Rye', '2026-07-07 13:35:21'),
(7, 'root@localhost', 'INSERT', 'books', '7', 'Added: To Kill a Mockingbird', '2026-07-07 13:35:21'),
(8, 'root@localhost', 'INSERT', 'books', '8', 'Added: A History of the World', '2026-07-07 13:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(10) UNSIGNED NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `publisher` varchar(150) DEFAULT NULL,
  `published_year` smallint(6) DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL,
  `shelf_location` varchar(50) DEFAULT NULL,
  `total_copies` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `available_copies` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` enum('available','unavailable','archived') NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `isbn`, `title`, `author`, `category_id`, `publisher`, `published_year`, `edition`, `shelf_location`, `total_copies`, `available_copies`, `status`, `created_at`, `updated_at`) VALUES
(1, '978-0131103627', 'The C Programming Language', 'Kernighan & Ritchie', 1, 'Prentice Hall', 1988, NULL, 'CS-A1', 3, 3, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(2, '978-0262033848', 'Introduction to Algorithms', 'Cormen et al.', 1, 'MIT Press', 2009, NULL, 'CS-A2', 2, 2, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(3, '978-0596009205', 'Head First SQL', 'Lynn Beighley', 1, 'O\'Reilly', 2007, NULL, 'CS-B1', 4, 4, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(4, '978-0201558029', 'Concrete Mathematics', 'Graham, Knuth, Patashnik', 2, 'Addison-Wesley', 1994, NULL, 'MA-C1', 2, 2, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(5, '978-0141439518', 'Pride and Prejudice', 'Jane Austen', 3, 'Penguin', 1813, NULL, 'FI-D1', 5, 5, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(6, '978-0316769488', 'The Catcher in the Rye', 'J. D. Salinger', 3, 'Little, Brown', 1951, NULL, 'FI-D2', 1, 1, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(7, '978-0060935467', 'To Kill a Mockingbird', 'Harper Lee', 3, 'Harper Perennial', 1960, NULL, 'FI-D3', 3, 3, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(8, '978-1400079278', 'A History of the World', 'Andrew Marr', 4, 'Pan Books', 2012, NULL, 'HI-E1', 2, 2, 'available', '2026-07-07 13:35:21', '2026-07-07 13:35:21');

--
-- Triggers `books`
--
DELIMITER $$
CREATE TRIGGER `trg_books_after_delete` AFTER DELETE ON `books` FOR EACH ROW BEGIN
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'DELETE', 'books', OLD.book_id, CONCAT('Deleted: ', OLD.title));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_books_after_insert` AFTER INSERT ON `books` FOR EACH ROW BEGIN
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'books', NEW.book_id, CONCAT('Added: ', NEW.title));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_books_stock_guard` BEFORE UPDATE ON `books` FOR EACH ROW BEGIN
    IF NEW.available_copies < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock error: available_copies cannot be negative.';
    END IF;
    IF NEW.available_copies > NEW.total_copies THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock error: available_copies cannot exceed total_copies.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `borrowing_id` int(10) UNSIGNED NOT NULL,
  `book_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `librarian_id` int(10) UNSIGNED DEFAULT NULL,
  `borrow_date` date NOT NULL DEFAULT curdate(),
  `due_date` date NOT NULL,
  `status` enum('borrowed','returned','overdue','lost') NOT NULL DEFAULT 'borrowed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Triggers `borrowings`
--
DELIMITER $$
CREATE TRIGGER `trg_borrow_after_insert` AFTER INSERT ON `borrowings` FOR EACH ROW BEGIN
    UPDATE books SET available_copies = available_copies - 1 WHERE book_id = NEW.book_id;
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'borrowings', NEW.borrowing_id,
            CONCAT('Book ', NEW.book_id, ' issued to member ', NEW.member_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Computer Science', 'Programming, databases, networks'),
(2, 'Mathematics', 'Pure and applied mathematics'),
(3, 'Fiction', 'Novels and short stories'),
(4, 'History', 'World and regional history');

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `fine_id` int(10) UNSIGNED NOT NULL,
  `borrowing_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` varchar(255) DEFAULT NULL,
  `status` enum('unpaid','paid','waived') NOT NULL DEFAULT 'unpaid',
  `issued_date` date NOT NULL DEFAULT curdate(),
  `paid_date` date DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `librarians`
--

CREATE TABLE `librarians` (
  `librarian_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `employee_no` varchar(30) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `hire_date` date NOT NULL DEFAULT curdate(),
  `privilege_level` enum('librarian','assistant') NOT NULL DEFAULT 'assistant',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `librarians`
--

INSERT INTO `librarians` (`librarian_id`, `user_id`, `employee_no`, `first_name`, `last_name`, `email`, `phone`, `hire_date`, `privilege_level`, `status`) VALUES
(1, 2, 'EMP-001', 'James', 'Brown', 'j.brown@library.tz', NULL, '2026-07-07', 'librarian', 'active'),
(2, 3, 'EMP-002', 'Amina', 'Kimwaga', 'a.kimwaga@library.tz', NULL, '2026-07-07', 'assistant', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(10) UNSIGNED NOT NULL,
  `membership_no` varchar(30) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `join_date` date NOT NULL DEFAULT curdate(),
  `status` enum('active','suspended','expired') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `membership_no`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `join_date`, `status`, `created_at`) VALUES
(1, 'MEM-0001', NULL, 'Grace', 'Mushi', 'grace.mushi@example.com', '+255700000001', NULL, '2025-01-15', 'active', '2026-07-07 13:35:21'),
(2, 'MEM-0002', NULL, 'Daniel', 'Owino', 'daniel.owino@example.com', '+255700000002', NULL, '2025-02-10', 'active', '2026-07-07 13:35:21'),
(3, 'MEM-0003', NULL, 'Fatuma', 'Hassan', 'fatuma.h@example.com', '+255700000003', NULL, '2025-03-05', 'active', '2026-07-07 13:35:21'),
(4, 'MEM-0004', NULL, 'Peter', 'Nyerere', 'peter.n@example.com', '+255700000004', NULL, '2025-04-20', 'active', '2026-07-07 13:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(10) UNSIGNED NOT NULL,
  `book_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `reserved_date` date NOT NULL DEFAULT curdate(),
  `expiry_date` date DEFAULT NULL,
  `status` enum('pending','fulfilled','cancelled','expired') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(10) UNSIGNED NOT NULL,
  `borrowing_id` int(10) UNSIGNED NOT NULL,
  `return_date` date NOT NULL DEFAULT curdate(),
  `book_condition` enum('good','damaged','lost') NOT NULL DEFAULT 'good',
  `received_by` int(10) UNSIGNED DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `returns`
--
DELIMITER $$
CREATE TRIGGER `trg_return_after_insert` AFTER INSERT ON `returns` FOR EACH ROW BEGIN
    DECLARE v_book_id INT UNSIGNED; DECLARE v_member_id INT UNSIGNED;
    DECLARE v_due DATE; DECLARE v_days_late INT; DECLARE v_rate DECIMAL(10,2);
    SELECT book_id, member_id, due_date INTO v_book_id, v_member_id, v_due
      FROM borrowings WHERE borrowing_id = NEW.borrowing_id;
    UPDATE books SET available_copies = available_copies + 1 WHERE book_id = v_book_id;
    UPDATE borrowings SET status = CASE WHEN NEW.book_condition='lost' THEN 'lost' ELSE 'returned' END
      WHERE borrowing_id = NEW.borrowing_id;
    SET v_days_late = DATEDIFF(NEW.return_date, v_due);
    IF v_days_late > 0 THEN
        SELECT CAST(setting_value AS DECIMAL(10,2)) INTO v_rate FROM system_settings WHERE setting_key='fine_per_day';
        INSERT INTO fines (borrowing_id, member_id, amount, reason, issued_date)
        VALUES (NEW.borrowing_id, v_member_id, v_days_late * COALESCE(v_rate,0),
                CONCAT(v_days_late,' day(s) overdue'), NEW.return_date);
    END IF;
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'returns', NEW.return_id,
            CONCAT('Loan ', NEW.borrowing_id, ' returned'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(1, 'admin', 'Full system access', '2026-07-07 13:35:21'),
(2, 'librarian', 'Manage catalogue, members, borrowing and returns', '2026-07-07 13:35:21'),
(3, 'assistant', 'Front-desk assistant with limited rights', '2026-07-07 13:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `filename` varchar(191) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schema_migrations`
--

INSERT INTO `schema_migrations` (`filename`, `applied_at`) VALUES
('migrations/001_create_roles_table.sql', '2026-07-07 13:35:20'),
('migrations/002_create_users_table.sql', '2026-07-07 13:35:20'),
('migrations/003_create_categories_table.sql', '2026-07-07 13:35:20'),
('migrations/004_create_books_table.sql', '2026-07-07 13:35:20'),
('migrations/005_create_members_table.sql', '2026-07-07 13:35:20'),
('migrations/006_create_librarians_table.sql', '2026-07-07 13:35:20'),
('migrations/007_create_borrowings_table.sql', '2026-07-07 13:35:20'),
('migrations/008_create_returns_table.sql', '2026-07-07 13:35:20'),
('migrations/009_create_reservations_table.sql', '2026-07-07 13:35:20'),
('migrations/010_create_fines_table.sql', '2026-07-07 13:35:20'),
('migrations/011_create_audit_logs_table.sql', '2026-07-07 13:35:20'),
('migrations/012_create_system_settings_table.sql', '2026-07-07 13:35:20'),
('migrations/013_create_indexes.sql', '2026-07-07 13:35:21'),
('migrations/014_create_views.sql', '2026-07-07 13:35:21'),
('migrations/015_trigger_books_stock_guard.sql', '2026-07-07 13:35:21'),
('migrations/016_trigger_borrow_after_insert.sql', '2026-07-07 13:35:21'),
('migrations/017_trigger_return_after_insert.sql', '2026-07-07 13:35:21'),
('migrations/018_trigger_books_after_insert.sql', '2026-07-07 13:35:21'),
('migrations/019_trigger_books_after_delete.sql', '2026-07-07 13:35:21'),
('migrations/020_procedure_borrow_book.sql', '2026-07-07 13:35:21'),
('migrations/021_procedure_return_book.sql', '2026-07-07 13:35:21'),
('migrations/022_procedure_mark_overdue.sql', '2026-07-07 13:35:21'),
('migrations/023_procedure_search_books.sql', '2026-07-07 13:35:21'),
('seeds/001_seed_roles.sql', '2026-07-07 13:35:21'),
('seeds/002_seed_users.sql', '2026-07-07 13:35:21'),
('seeds/003_seed_librarians.sql', '2026-07-07 13:35:21'),
('seeds/004_seed_categories.sql', '2026-07-07 13:35:21'),
('seeds/005_seed_books.sql', '2026-07-07 13:35:21'),
('seeds/006_seed_members.sql', '2026-07-07 13:35:21'),
('seeds/007_seed_settings.sql', '2026-07-07 13:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(60) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
('fine_per_day', '500', 'Overdue fine per day (TZS)'),
('library_name', 'MAGA Community Library', 'Display name'),
('loan_period', '14', 'Default loan period in days'),
('max_books', '5', 'Maximum concurrent loans per member');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive','locked') NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `username`, `email`, `password_hash`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admin@library.tz', '$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.', 'active', NULL, '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(2, 2, 'jbrown', 'j.brown@library.tz', '$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.', 'active', NULL, '2026-07-07 13:35:21', '2026-07-07 13:35:21'),
(3, 3, 'akimwaga', 'a.kimwaga@library.tz', '$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.', 'active', NULL, '2026-07-07 13:35:21', '2026-07-07 13:35:21');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_book_availability`
-- (See below for the actual view)
--
CREATE TABLE `vw_book_availability` (
`book_id` int(10) unsigned
,`isbn` varchar(20)
,`title` varchar(255)
,`author` varchar(150)
,`category` varchar(100)
,`total_copies` int(10) unsigned
,`available_copies` int(10) unsigned
,`copies_on_loan` bigint(11) unsigned
,`status` enum('available','unavailable','archived')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_member_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_member_summary` (
`member_id` int(10) unsigned
,`member_name` varchar(161)
,`status` enum('active','suspended','expired')
,`total_borrowings` bigint(21)
,`active_loans` decimal(22,0)
,`outstanding_fines` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_most_borrowed_books`
-- (See below for the actual view)
--
CREATE TABLE `vw_most_borrowed_books` (
`book_id` int(10) unsigned
,`title` varchar(255)
,`author` varchar(150)
,`times_borrowed` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_overdue_books`
-- (See below for the actual view)
--
CREATE TABLE `vw_overdue_books` (
`borrowing_id` int(10) unsigned
,`book_id` int(10) unsigned
,`title` varchar(255)
,`member_id` int(10) unsigned
,`member_name` varchar(161)
,`borrow_date` date
,`due_date` date
,`days_overdue` int(7)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_book_availability`
--
DROP TABLE IF EXISTS `vw_book_availability`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_book_availability`  AS SELECT `b`.`book_id` AS `book_id`, `b`.`isbn` AS `isbn`, `b`.`title` AS `title`, `b`.`author` AS `author`, `c`.`name` AS `category`, `b`.`total_copies` AS `total_copies`, `b`.`available_copies` AS `available_copies`, `b`.`total_copies`- `b`.`available_copies` AS `copies_on_loan`, `b`.`status` AS `status` FROM (`books` `b` left join `categories` `c` on(`c`.`category_id` = `b`.`category_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_member_summary`
--
DROP TABLE IF EXISTS `vw_member_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_member_summary`  AS SELECT `m`.`member_id` AS `member_id`, concat(`m`.`first_name`,' ',`m`.`last_name`) AS `member_name`, `m`.`status` AS `status`, count(distinct `br`.`borrowing_id`) AS `total_borrowings`, sum(case when `br`.`status` in ('borrowed','overdue') then 1 else 0 end) AS `active_loans`, coalesce(sum(case when `f`.`status` = 'unpaid' then `f`.`amount` else 0 end),0) AS `outstanding_fines` FROM ((`members` `m` left join `borrowings` `br` on(`br`.`member_id` = `m`.`member_id`)) left join `fines` `f` on(`f`.`member_id` = `m`.`member_id`)) GROUP BY `m`.`member_id`, concat(`m`.`first_name`,' ',`m`.`last_name`), `m`.`status` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_most_borrowed_books`
--
DROP TABLE IF EXISTS `vw_most_borrowed_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_most_borrowed_books`  AS SELECT `b`.`book_id` AS `book_id`, `b`.`title` AS `title`, `b`.`author` AS `author`, count(`br`.`borrowing_id`) AS `times_borrowed` FROM (`books` `b` left join `borrowings` `br` on(`br`.`book_id` = `b`.`book_id`)) GROUP BY `b`.`book_id`, `b`.`title`, `b`.`author` ORDER BY count(`br`.`borrowing_id`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_overdue_books`
--
DROP TABLE IF EXISTS `vw_overdue_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_overdue_books`  AS SELECT `br`.`borrowing_id` AS `borrowing_id`, `b`.`book_id` AS `book_id`, `b`.`title` AS `title`, `m`.`member_id` AS `member_id`, concat(`m`.`first_name`,' ',`m`.`last_name`) AS `member_name`, `br`.`borrow_date` AS `borrow_date`, `br`.`due_date` AS `due_date`, to_days(curdate()) - to_days(`br`.`due_date`) AS `days_overdue` FROM ((`borrowings` `br` join `books` `b` on(`b`.`book_id` = `br`.`book_id`)) join `members` `m` on(`m`.`member_id` = `br`.`member_id`)) WHERE `br`.`status` in ('borrowed','overdue') AND `br`.`due_date` < curdate() ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `idx_audit_table` (`table_name`,`created_at`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `uq_books_isbn` (`isbn`),
  ADD KEY `idx_books_title` (`title`),
  ADD KEY `idx_books_author` (`author`),
  ADD KEY `idx_books_category` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `fk_borrow_librarian` (`librarian_id`),
  ADD KEY `idx_borrow_status` (`status`),
  ADD KEY `idx_borrow_due` (`due_date`),
  ADD KEY `idx_borrow_book` (`book_id`),
  ADD KEY `idx_borrow_member` (`member_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `uq_categories_name` (`name`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`fine_id`),
  ADD KEY `fk_fines_borrow` (`borrowing_id`),
  ADD KEY `fk_fines_member` (`member_id`),
  ADD KEY `idx_fines_status` (`status`);

--
-- Indexes for table `librarians`
--
ALTER TABLE `librarians`
  ADD PRIMARY KEY (`librarian_id`),
  ADD UNIQUE KEY `uq_librarians_emp` (`employee_no`),
  ADD KEY `fk_librarians_user` (`user_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `uq_members_no` (`membership_no`),
  ADD UNIQUE KEY `uq_members_email` (`email`),
  ADD KEY `fk_members_user` (`user_id`),
  ADD KEY `idx_members_name` (`last_name`,`first_name`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_res_book` (`book_id`),
  ADD KEY `fk_res_member` (`member_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD UNIQUE KEY `uq_returns_borrow` (`borrowing_id`),
  ADD KEY `fk_returns_by` (`received_by`),
  ADD KEY `idx_returns_date` (`return_date`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `uq_roles_name` (`role_name`);

--
-- Indexes for table `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD PRIMARY KEY (`filename`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `borrowing_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `fine_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `librarians`
--
ALTER TABLE `librarians`
  MODIFY `librarian_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `fk_borrow_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_borrow_librarian` FOREIGN KEY (`librarian_id`) REFERENCES `librarians` (`librarian_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_borrow_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON UPDATE CASCADE;

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fk_fines_borrow` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`borrowing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fines_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `librarians`
--
ALTER TABLE `librarians`
  ADD CONSTRAINT `fk_librarians_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `fk_members_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_res_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `fk_returns_borrow` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`borrowing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_returns_by` FOREIGN KEY (`received_by`) REFERENCES `librarians` (`librarian_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

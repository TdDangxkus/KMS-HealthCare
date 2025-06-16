<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'qickmed');

// Site Configuration
define('SITE_NAME', 'Qickmed Medical & Health Care');
define('SITE_URL', 'http://localhost');

// Feature Flags
define('ENABLE_AUTO_DISCOUNT', true);  // Set to false to disable automatic discounts
define('AUTO_DISCOUNT_PERCENT', 10);    // Default discount percentage
define('AUTO_DISCOUNT_MIN_RATING', 4.5); // Minimum rating required for discount 


-- Tạo bảng cấu hình
CREATE TABLE IF NOT EXISTS `site_config` (
  `config_key` varchar(50) NOT NULL PRIMARY KEY,
  `config_value` varchar(255) NOT NULL,
  `description` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm cấu hình mặc định
INSERT INTO `site_config` (`config_key`, `config_value`, `description`) VALUES
('enable_auto_discount', 'true', 'Bật/tắt tính năng giảm giá tự động'),
('auto_discount_percent', '10', 'Phần trăm giảm giá tự động'),
('auto_discount_min_rating', '4.5', 'Điểm đánh giá tối thiểu để được giảm giá');

UPDATE site_config SET config_value = 'false' WHERE config_key = 'enable_auto_discount';

UPDATE site_config SET config_value = 'true' WHERE config_key = 'enable_auto_discount';
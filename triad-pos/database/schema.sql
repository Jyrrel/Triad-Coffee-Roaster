-- 1) Create database (run in phpMyAdmin / MySQL)
CREATE DATABASE IF NOT EXISTS triad_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE triad_pos;

-- 2) Users table
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('owner','staff') NOT NULL DEFAULT 'staff',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_role_active (role, is_active)
) ENGINE=InnoDB;


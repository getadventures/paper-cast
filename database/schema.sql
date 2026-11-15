-- Paper Cast database schema
-- Safe on an existing paper_cast database: creates missing tables, does not drop tables.
CREATE DATABASE IF NOT EXISTS paper_cast CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE paper_cast;

CREATE TABLE IF NOT EXISTS categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 slug VARCHAR(120) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
 category_id INT UNSIGNED NULL,
 title VARCHAR(200) NOT NULL,
 slug VARCHAR(220) NOT NULL,
 excerpt TEXT NULL,
 content LONGTEXT NOT NULL,
 cover_image VARCHAR(500) NULL,
 status ENUM('draft','published') NOT NULL DEFAULT 'draft',
 published_at DATETIME NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (id), UNIQUE KEY uq_posts_slug (slug),
 KEY idx_posts_status_published (status,published_at), KEY idx_posts_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 setting_key VARCHAR(100) NOT NULL UNIQUE,
 setting_value TEXT NULL,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT IGNORE INTO settings(setting_key,setting_value) VALUES ('active_theme','paper-cast');

CREATE TABLE IF NOT EXISTS admins (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS comments (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 post_id BIGINT UNSIGNED NOT NULL,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL,
 body TEXT NOT NULL,
 status ENUM('pending','approved','spam') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 KEY idx_comments_post_status(post_id,status),
 CONSTRAINT fk_comments_post FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS post_likes (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 post_id BIGINT UNSIGNED NOT NULL,
 visitor_hash CHAR(64) NOT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uq_post_visitor(post_id,visitor_hash),
 CONSTRAINT fk_likes_post FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO categories(name,slug) VALUES
 ('Culture','culture'),('Ideas','ideas'),('Technology','technology'),('Lifestyle','lifestyle');

INSERT INTO posts(category_id,title,slug,excerpt,content,status,published_at)
SELECT NULL,'Welcome to Paper Cast','welcome-to-paper-cast',
 'A new home for thoughtful ideas, useful discoveries, and stories worth sharing.',
 'Paper Cast is an independent publication built around curiosity. Replace this sample with your first story.',
 'published',NOW()
WHERE NOT EXISTS(SELECT 1 FROM posts);

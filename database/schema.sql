CREATE DATABASE IF NOT EXISTS paper_cast CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE paper_cast;
CREATE TABLE IF NOT EXISTS categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 slug VARCHAR(120) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS posts (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id INT UNSIGNED NULL,
 title VARCHAR(200) NOT NULL,
 slug VARCHAR(220) NOT NULL UNIQUE,
 excerpt TEXT NULL,
 content LONGTEXT NOT NULL,
 cover_image VARCHAR(500) NULL,
 status ENUM('draft','published') NOT NULL DEFAULT 'draft',
 published_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_posts_category FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL,
 INDEX idx_posts_status_published(status,published_at)
) ENGINE=InnoDB;
INSERT IGNORE INTO categories(name,slug) VALUES ('Culture','culture'),('Ideas','ideas'),('Technology','technology'),('Lifestyle','lifestyle');
INSERT IGNORE INTO posts(category_id,title,slug,excerpt,content,status,published_at) VALUES
(2,'Welcome to Paper Cast','welcome-to-paper-cast','A new home for thoughtful ideas, useful discoveries, and stories worth sharing.','Paper Cast is an independent publication built around curiosity. Replace this sample with your first story.','published',NOW());

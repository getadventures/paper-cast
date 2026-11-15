-- Paper Cast database repair
-- Safe to run on an existing paper_cast database: it does not drop or rename tables.
USE paper_cast;

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
    PRIMARY KEY (id),
    UNIQUE KEY uq_posts_slug (slug),
    KEY idx_posts_status_published (status, published_at),
    KEY idx_posts_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add one starter article only when the table is empty.
INSERT INTO posts (category_id, title, slug, excerpt, content, status, published_at)
SELECT NULL, 'Welcome to Paper Cast', 'welcome-to-paper-cast',
       'A new home for thoughtful ideas, useful discoveries, and stories worth sharing.',
       'Paper Cast is an independent publication built around curiosity. Replace this sample with your first story.',
       'published', NOW()
WHERE NOT EXISTS (SELECT 1 FROM posts);

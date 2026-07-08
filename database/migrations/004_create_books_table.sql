-- Migration 004 — books
CREATE TABLE IF NOT EXISTS books (
    book_id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    isbn             VARCHAR(20)  NOT NULL,
    title            VARCHAR(255) NOT NULL,
    author           VARCHAR(150) NOT NULL,
    category_id      INT UNSIGNED NULL,
    publisher        VARCHAR(150) NULL,
    published_year   SMALLINT     NULL,
    edition          VARCHAR(50)  NULL,
    shelf_location   VARCHAR(50)  NULL,
    total_copies     INT UNSIGNED NOT NULL DEFAULT 1,
    available_copies INT UNSIGNED NOT NULL DEFAULT 1,
    status           ENUM('available','unavailable','archived') NOT NULL DEFAULT 'available',
    created_at       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_books                 PRIMARY KEY (book_id),
    CONSTRAINT uq_books_isbn            UNIQUE (isbn),
    CONSTRAINT fk_books_category        FOREIGN KEY (category_id) REFERENCES categories (category_id)
                                        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT chk_books_total_nonneg   CHECK (total_copies     >= 0),
    CONSTRAINT chk_books_avail_nonneg   CHECK (available_copies >= 0),
    CONSTRAINT chk_books_avail_le_total CHECK (available_copies <= total_copies),
    CONSTRAINT chk_books_year           CHECK (published_year IS NULL OR published_year BETWEEN 1400 AND 2100)
) ENGINE=InnoDB;

-- Migration 008 — returns
CREATE TABLE IF NOT EXISTS returns (
    return_id      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    borrowing_id   INT UNSIGNED NOT NULL,
    return_date    DATE         NOT NULL DEFAULT (CURRENT_DATE),
    book_condition ENUM('good','damaged','lost') NOT NULL DEFAULT 'good',
    received_by    INT UNSIGNED NULL,
    remarks        VARCHAR(255) NULL,
    created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_returns        PRIMARY KEY (return_id),
    CONSTRAINT uq_returns_borrow UNIQUE (borrowing_id),
    CONSTRAINT fk_returns_borrow FOREIGN KEY (borrowing_id) REFERENCES borrowings (borrowing_id)
                                 ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_returns_by     FOREIGN KEY (received_by)  REFERENCES librarians (librarian_id)
                                 ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Migration 007 — borrowings
CREATE TABLE IF NOT EXISTS borrowings (
    borrowing_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    book_id      INT UNSIGNED NOT NULL,
    member_id    INT UNSIGNED NOT NULL,
    librarian_id INT UNSIGNED NULL,
    borrow_date  DATE         NOT NULL DEFAULT (CURRENT_DATE),
    due_date     DATE         NOT NULL,
    status       ENUM('borrowed','returned','overdue','lost') NOT NULL DEFAULT 'borrowed',
    created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_borrowings       PRIMARY KEY (borrowing_id),
    CONSTRAINT fk_borrow_book      FOREIGN KEY (book_id)      REFERENCES books (book_id)
                                   ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_borrow_member    FOREIGN KEY (member_id)    REFERENCES members (member_id)
                                   ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_borrow_librarian FOREIGN KEY (librarian_id) REFERENCES librarians (librarian_id)
                                   ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT chk_borrow_dates    CHECK (due_date >= borrow_date)
) ENGINE=InnoDB;

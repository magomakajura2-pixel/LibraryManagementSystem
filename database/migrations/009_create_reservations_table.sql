-- Migration 009 — reservations
CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    book_id        INT UNSIGNED NOT NULL,
    member_id      INT UNSIGNED NOT NULL,
    reserved_date  DATE         NOT NULL DEFAULT (CURRENT_DATE),
    expiry_date    DATE         NULL,
    status         ENUM('pending','fulfilled','cancelled','expired') NOT NULL DEFAULT 'pending',
    CONSTRAINT pk_reservations PRIMARY KEY (reservation_id),
    CONSTRAINT fk_res_book     FOREIGN KEY (book_id)   REFERENCES books (book_id)
                               ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_res_member   FOREIGN KEY (member_id) REFERENCES members (member_id)
                               ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

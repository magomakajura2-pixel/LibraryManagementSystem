-- Migration 010 — fines
CREATE TABLE IF NOT EXISTS fines (
    fine_id      INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    borrowing_id INT UNSIGNED  NOT NULL,
    member_id    INT UNSIGNED  NOT NULL,
    amount       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    reason       VARCHAR(255)  NULL,
    status       ENUM('unpaid','paid','waived') NOT NULL DEFAULT 'unpaid',
    issued_date  DATE          NOT NULL DEFAULT (CURRENT_DATE),
    paid_date    DATE          NULL,
    CONSTRAINT pk_fines        PRIMARY KEY (fine_id),
    CONSTRAINT fk_fines_borrow FOREIGN KEY (borrowing_id) REFERENCES borrowings (borrowing_id)
                               ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_fines_member FOREIGN KEY (member_id)    REFERENCES members (member_id)
                               ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT chk_fines_amount CHECK (amount >= 0)
) ENGINE=InnoDB;

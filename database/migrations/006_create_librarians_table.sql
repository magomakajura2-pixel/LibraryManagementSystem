-- Migration 006 — librarians
CREATE TABLE IF NOT EXISTS librarians (
    librarian_id    INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id         INT UNSIGNED NOT NULL,
    employee_no     VARCHAR(30)  NOT NULL,
    first_name      VARCHAR(80)  NOT NULL,
    last_name       VARCHAR(80)  NOT NULL,
    email           VARCHAR(150) NULL,
    phone           VARCHAR(30)  NULL,
    hire_date       DATE         NOT NULL DEFAULT (CURRENT_DATE),
    privilege_level ENUM('librarian','assistant') NOT NULL DEFAULT 'assistant',
    status          ENUM('active','inactive') NOT NULL DEFAULT 'active',
    CONSTRAINT pk_librarians      PRIMARY KEY (librarian_id),
    CONSTRAINT uq_librarians_emp  UNIQUE (employee_no),
    CONSTRAINT fk_librarians_user FOREIGN KEY (user_id) REFERENCES users (user_id)
                                  ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

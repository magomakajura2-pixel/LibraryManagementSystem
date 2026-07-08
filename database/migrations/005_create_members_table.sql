-- Migration 005 — members
CREATE TABLE IF NOT EXISTS members (
    member_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    membership_no VARCHAR(30)  NOT NULL,
    user_id       INT UNSIGNED NULL,
    first_name    VARCHAR(80)  NOT NULL,
    last_name     VARCHAR(80)  NOT NULL,
    email         VARCHAR(150) NULL,
    phone         VARCHAR(30)  NULL,
    address       VARCHAR(255) NULL,
    join_date     DATE         NOT NULL DEFAULT (CURRENT_DATE),
    status        ENUM('active','suspended','expired') NOT NULL DEFAULT 'active',
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_members       PRIMARY KEY (member_id),
    CONSTRAINT uq_members_no    UNIQUE (membership_no),
    CONSTRAINT uq_members_email UNIQUE (email),
    CONSTRAINT fk_members_user  FOREIGN KEY (user_id) REFERENCES users (user_id)
                                ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

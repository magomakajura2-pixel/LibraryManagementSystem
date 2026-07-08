-- Migration 001 — roles
CREATE TABLE IF NOT EXISTS roles (
    role_id     INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    role_name   VARCHAR(50)   NOT NULL,
    description VARCHAR(255)  NULL,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_roles      PRIMARY KEY (role_id),
    CONSTRAINT uq_roles_name UNIQUE (role_name)
) ENGINE=InnoDB;

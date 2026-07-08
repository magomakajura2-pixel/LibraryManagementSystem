-- Migration 011 — audit_logs
CREATE TABLE IF NOT EXISTS audit_logs (
    log_id     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    actor      VARCHAR(150)    NOT NULL,
    action     VARCHAR(20)     NOT NULL,
    table_name VARCHAR(64)     NOT NULL,
    record_id  VARCHAR(64)     NULL,
    details    VARCHAR(500)    NULL,
    created_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_audit_logs PRIMARY KEY (log_id)
) ENGINE=InnoDB;

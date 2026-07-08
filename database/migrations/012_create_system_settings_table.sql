-- Migration 012 — system_settings
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key   VARCHAR(60)  NOT NULL,
    setting_value VARCHAR(255) NOT NULL,
    description   VARCHAR(255) NULL,
    CONSTRAINT pk_settings PRIMARY KEY (setting_key)
) ENGINE=InnoDB;

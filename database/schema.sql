CREATE DATABASE IF NOT EXISTS denyudin_robert_cat;
USE denyudin_robert_cat;

CREATE TABLE translation_units (
    id INT PRIMARY KEY AUTO_INCREMENT,
    source_language VARCHAR(10) NOT NULL,
    target_language VARCHAR(10) NOT NULL,
    source_text TEXT NOT NULL,
    target_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE history_translation_units (
    id INT PRIMARY KEY AUTO_INCREMENT,
    translation_unit_id INT,
    old_data_json json NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (translation_unit_id) REFERENCES translation_units(id)
);

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS p1docker;
USE p1docker;

CREATE TABLE IF NOT EXISTS productes (
    idp        INT AUTO_INCREMENT PRIMARY KEY,
    nomarticle VARCHAR(100) NOT NULL,
    preu       DECIMAL(8,2) NOT NULL
);

INSERT INTO productes (nomarticle, preu) VALUES
    ('Teclat', 59.90),
    ('Ratolí', 24.50),
    ('Monitor', 149.00),
    ('Auriculars', 39.99),
    ('Webcam', 45.00);

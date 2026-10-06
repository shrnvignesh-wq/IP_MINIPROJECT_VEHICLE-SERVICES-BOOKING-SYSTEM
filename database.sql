-- =====================================================================
-- Vehicle Services Booking System
-- Database: vehicle_service_db
-- Import this file via phpMyAdmin (XAMPP) or:
--   mysql -u root -p < database.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS vehicle_service_db;
USE vehicle_service_db;

-- ---------------------------------------------------------------------
-- Table: users  (stores registered customers)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100)  NOT NULL,
    email       VARCHAR(100)  NOT NULL UNIQUE,
    phone       VARCHAR(15)   NOT NULL,
    password    VARCHAR(255)  NOT NULL,      -- stored as a password_hash()
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
-- Table: services  (catalogue of vehicle services offered)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    service_id    INT AUTO_INCREMENT PRIMARY KEY,
    service_name  VARCHAR(100)  NOT NULL,
    description   VARCHAR(255),
    price         DECIMAL(8,2)  NOT NULL,
    duration_mins INT           NOT NULL
);

-- ---------------------------------------------------------------------
-- Table: bookings  (dynamic data created by users)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS bookings (
    booking_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT NOT NULL,
    service_id     INT NOT NULL,
    vehicle_number VARCHAR(20)  NOT NULL,
    vehicle_type   VARCHAR(30)  NOT NULL,
    booking_date   DATE         NOT NULL,
    booking_time   TIME         NOT NULL,
    status         ENUM('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(user_id)       ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
);

-- ---------------------------------------------------------------------
-- Seed data: services catalogue
-- ---------------------------------------------------------------------
INSERT INTO services (service_name, description, price, duration_mins) VALUES
('Basic Car Wash',        'Exterior foam wash and dry wipe',              299.00,  30),
('General Service',       'Oil change, filter check, and inspection',    1499.00, 120),
('Engine Diagnostics',    'Computerized engine health scan',              899.00,  45),
('Tyre Alignment & Balancing', 'Wheel alignment and dynamic balancing',   699.00,  60),
('Battery Check & Replace',    'Battery health test and replacement',     499.00,  30),
('Two-Wheeler Full Service',   'Complete servicing for bikes/scooters',   699.00,  90);

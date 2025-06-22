CREATE DATABASE IF NOT EXISTS driveasy;
USE driveasy;

-- Cars Table
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year YEAR NOT NULL,
    type VARCHAR(50) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255)
);

-- Services Table
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) NOT NULL
);

-- Messages Table (for contact form)
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Sample Data
INSERT INTO cars (make, model, year, type, price_per_day, image_url) VALUES
('Toyota', 'Camry', 2022, 'Sedan', 4500, 'camry.jpg'),
('Honda', 'CR-V', 2023, 'SUV', 6000, 'crv.jpg'),
('Ford', 'Mustang', 2022, 'Sports', 8500, 'mustang.jpg'),
('Hyundai', 'Elantra', 2023, 'Sedan', 4000, 'elantra.jpg');

INSERT INTO services (title, description, icon) VALUES
('24/7 Road Assistance', 'Our team is always ready to help you on the road', '🛟'),
('Flexible Rental Periods', 'Rent by hour, day, week or month', '⏱️'),
('Free Cancellation', 'Cancel anytime with no fees', '❌'),
('Child Seats Available', 'Keep your little ones safe', '👶');
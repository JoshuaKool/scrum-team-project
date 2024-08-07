DROP DATABASE IF EXISTS `StayNetherlands`;

CREATE DATABASE `StayNetherlands`;

USE `StayNetherlands`;

CREATE TABLE `users` (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    role ENUM('sell', 'buy', 'admin') NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    profile_image LONGBLOB,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE `houses` (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    house_type ENUM('flat', 'villa', 'rijtjeshuis', 'appartment') NOT NULL,
    country VARCHAR(255) NOT NULL,
    place VARCHAR(255) NOT NULL,
    seller_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    rating DECIMAL(3, 2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    rooms INT NOT NULL,
    pets_allowed ENUM('yes', 'no') NOT NULL,
    parkingplace ENUM('yes', 'no') NOT NULL,
    accessible_disabled_people ENUM('yes', 'no') NOT NULL,
    smoking_allowed ENUM('yes', 'no') NOT NULL,
    garden ENUM('yes', 'no') NOT NULL,
    balcony ENUM('yes', 'no') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

CREATE TABLE `rented` (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    house_id INT NOT NULL,
    renter_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (house_id) REFERENCES houses(id),
    FOREIGN KEY (renter_id) REFERENCES users(id)
);

CREATE TABLE `reviews` (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    rating DECIMAL(3, 2) NOT NULL,
    review TEXT NOT NULL,
    house_id INT NOT NULL,
    reviewer_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (house_id) REFERENCES houses(id),
    FOREIGN KEY (reviewer_id) REFERENCES users(id)
);

CREATE TABLE `house_images` (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    house_id INT NOT NULL,
    image LONGBLOB NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (house_id) REFERENCES houses(id)
);
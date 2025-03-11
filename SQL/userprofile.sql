-- Create the database
CREATE DATABASE IF NOT EXISTS ph_company;

-- Use the database
USE ph_company;

-- Create the user_profiles table
CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    birthdate DATE NOT NULL,
    job_title VARCHAR(255) NOT NULL
);
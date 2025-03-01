-- Create and use the database
CREATE DATABASE IF NOT EXISTS ph_company;
USE ph_company;

-- Create Office table
CREATE TABLE IF NOT EXISTS office (
    id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contactnum VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255),
    city VARCHAR(100),
    country VARCHAR(100),
    postal VARCHAR(20)
);

-- Create Employee table
CREATE TABLE IF NOT EXISTS employee (
    id INT PRIMARY KEY,
    lastname VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    office_id INT,
    address VARCHAR(255),
    FOREIGN KEY (office_id) REFERENCES office(id)
);

-- Create Transaction table
CREATE TABLE IF NOT EXISTS transaction (
    id INT PRIMARY KEY,
    employee_id INT,
    office_id INT,
    datelog DATETIME NOT NULL,
    action VARCHAR(50) NOT NULL,
    remarks TEXT,
    documentcode VARCHAR(20),
    FOREIGN KEY (employee_id) REFERENCES employee(id),
    FOREIGN KEY (office_id) REFERENCES office(id)
);
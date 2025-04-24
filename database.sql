CREATE DATABASE IF NOT EXISTS airline;
USE airline;

CREATE TABLE flights (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flight_number VARCHAR(20),
  departure VARCHAR(50),
  arrival VARCHAR(50),
  date DATE,
  price DECIMAL(10,2)
);

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flight_id INT,
  name VARCHAR(100),
  seat VARCHAR(10),
  reference VARCHAR(50),
  FOREIGN KEY (flight_id) REFERENCES flights(id)
);
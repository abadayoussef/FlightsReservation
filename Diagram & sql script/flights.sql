-- create and use database
CREATE DATABASE flightManagment;
USE flightManagment;

-- create tables
CREATE TABLE Client(
    id_client INT AUTO_INCREMENT,
    first_name VARCHAR(50), 
    last_name VARCHAR(50),
    id_card VARCHAR(10) UNIQUE,
    passport VARCHAR(10) UNIQUE,
    nationality VARCHAR(50),
    birthday DATETIME,
    email VARCHAR(60),
    password_user VARCHAR(100);
    phone VARCHAR(15),
    PRIMARY KEY(id_client)
);

CREATE TABLE Flight(
    id_flight INT AUTO_INCREMENT,
    plane_name VARCHAR(50),
    depart VARCHAR(80), 
    distination VARCHAR(80),
    date_flight DATETIME, 
    price INT,
    total_places INT,
    PRIMARY KEY(id_flight)
);

CREATE TABLE Reservation(
    id_resevation INT AUTO_INCREMENT, 
    id_flight INT, 
    id_client INT, 
    date_resevation DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_resevation), 
    FOREIGN KEY (id_flight) references Flight(id_flight), 
    FOREIGN KEY (id_client) references Client(id_client)
);

-- add rows
INSERT INTO Flight(plane_name, depart, distination, date_flight, price, total_places) 
VALUES 
('Qatar Airways', 'Morocco', 'Egypt', '2020-05-23', 1500, 100),
('Singapore Airlines', 'Morocco', 'France', '2020-06-02', 2000, 150),
('Emirates', 'Spain', 'UK', '2020-06-02', 1000, 80),
('ANA All Nippon Airways', 'France', 'Japan', '2020-06-04', 10000, 200),
('EVA Air', 'France', 'China', '2020-06-10', 10100, 100);

-- create trigger
DELIMITER $$
CREATE TRIGGER reservePlace 
AFTER INSERT ON Reservation FOR EACH ROW
BEGIN
UPDATE Flight SET Flight.total_places = Flight.total_places - 1 WHERE Flight.id_flight = NEW.id_flight;
END $$
DELIMITER ;
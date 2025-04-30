/*******************************************************************************
   BrightMinds Database - Version 1.4
   Script: Chinook_Sqlite.sql
   Description: Creates and populates the BrightMinds database.
   DB Server: Sqlite
   Author: Carolina Roque, Ana Alves, Mateus Guerra
   License: http://www.codeplex.com/ChinookDatabase/license
********************************************************************************/

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Freelancer;
DROP TABLE IF EXISTS Availability;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Booking;
DROP TABLE IF EXISTS Transfer;
DROP TABLE IF EXISTS Review;

/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE User (
    user_id INTEGER PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    birth_data DATE NOT NULL,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    usertype TEXT CHECK(usertype IN ('estudante', 'explicador', 'admin')) NOT NULL,
    data_registo DATE NOT NULL
);

CREATE TABLE Freelancer (
    freelancer_id INTEGER PRIMARY KEY,
    biography TEXT,
    FOREIGN KEY (freelancer_id) REFERENCES Users(user_id) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE Availability (
    availability_id INTEGER PRIMARY KEY,
    freelancer_id INTEGER NOT NULL,
    week_day TEXT CHECK(week_day IN ('segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo')),
    hora_inicio TEXT NOT NULL,
    hora_fim TEXT NOT NULL,
    FOREIGN KEY (freelancer_id) REFERENCES Freelancers(freelancer_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Message (
    message_id INTEGER PRIMARY KEY,
    sender_id INTEGER,
    receiver_id INTEGER,
    msg TEXT NOT NULL,
    data_envio DATE NOT NULL,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Freelancers(freelancer_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Service(
    service_id INTEGER PRIMARY KEY,
    freelancer_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    category_name TEXT NOT NULL,
    description TEXT NOT NULL,
    duracao INTEGER NOT NULL,
    price REAL NOT NULL,
    service_type TEXT CHECK(service_type IN ('individual presencial', 'grupo presencial', 'individual online','grupo online', 'revisão trabalhos')) NOT NULL,
    num_sessoes INTEGER NOT NULL,
    status TEXT CHECK(status IN ('ativo', 'inativo')) DEFAULT 'ativo',
    FOREIGN KEY (freelancer_id) REFERENCES Freelancers(freelancer_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (category_name) REFERENCES Category(category_name) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Category(
    category_name TEXT PRIMARY KEY
);

CREATE TABLE Booking (
    booking_id INTEGER PRIMARY KEY,
    cliente_id INTEGER,
    service_id INTEGER NOT NULL,
    data_agendamento DATE NOT NULL,
    status TEXT CHECK(status IN ('pendente', 'completo', 'cancelado')) DEFAULT 'pendente',
    FOREIGN KEY (cliente_id) REFERENCES Users(user_id) ON DELETE SET NULL ON UPDATE CASCADE /*Se quisermos preservar as reservas mesmo que um cliente seja apagado:*/
    FOREIGN KEY (service_id) REFERENCES Services(service_id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE Transfer (
    transaction_id INTEGER PRIMARY KEY,
    booking_id INTEGER NOT NULL,
    valor REAL NOT NULL,
    data_transacao DATE NOT NULL,
    metodo_pagamento TEXT CHECK(metodo_pagamento IN ('MBWAY', 'VISA', 'PayPal', 'Apple Pay')) DEFAULT 'pendente',
    FOREIGN KEY (booking_id) REFERENCES Booking(booking_id) ON DELETE RESTRICT ON UPDATE CASCADE /*On delete restrict impede de apagar o booking se houver uma transação associada*/
);

-- Avaliações feitas após o serviço
CREATE TABLE Review (
    review_id INTEGER PRIMARY KEY,
    booking_id INTEGER UNIQUE NOT NULL, 
    rating INTEGER NOT NULL CHECK(rating BETWEEN 1 AND 5),
    comment TEXT,
    data_avaliacao DATE NOT NULL,
    FOREIGN KEY (booking_id) REFERENCES Booking(booking_id) ON DELETE RESTRICT ON UPDATE CASCADE /*On delete restrict bloqueia o apagamento da marcação se existir uma review associada.c*/
);

INSERT INTO User VALUES (NULL,'anitalves08', '25-03-2005', 'Ana Alves', 'anafalves999@gmail.com', '1234', 'admin', '30-04-2025');

INSERT INTO Category VALUES('Math');
INSERT INTO Category VALUES('Science');
INSERT INTO Category VALUES('Portuguese');
INSERT INTO Category VALUES('English');



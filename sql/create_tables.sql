-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Asiakas(
  id SERIAL PRIMARY KEY,
  email varchar(120) NOT NULL,
  puh varchar(15) NOT NULL,
  etunimi varchar(40),
  sukunimi varchar(40),
  password varchar(50) NOT NULL,
  onkoAdmin boolean NOT NULL
);
-- 
CREATE TABLE Seurantalista(
  id SERIAL PRIMARY KEY,
  pvm timestamp
);
-- 
CREATE TABLE Esite(
  id SERIAL PRIMARY KEY,
  nimi varchar(40) NOT NULL,
  kuva bytea,
  aloitusHinta numeric,
  avattu timestamp,
  sulkeutuu timestamp NOT NULL,
  kuvaus varchar(500)
);
-- 
CREATE TABLE Tarjous(
  id SERIAL PRIMARY KEY,
  asiakas_id INTEGER REFERENCES Asiakas(id) ON DELETE CASCADE,
--   seurantalista_id INTEGER REFERENCES Seurantalista(id) ON DELETE CASCADE,
  esite_id INTEGER REFERENCES Esite(id) ON DELETE CASCADE,
  summa numeric NOT NULL,
  pvm timestamp
);
-- 
CREATE TABLE Tuoteluokka(
  id SERIAL PRIMARY KEY,
  nimi varchar(40) NOT NULL
);
-- 
CREATE TABLE EsitteenTuoteluokka(
  esite_id INTEGER REFERENCES Esite(id) ON DELETE CASCADE,
  tuoteluokka_id INTEGER REFERENCES Tuoteluokka(id) ON DELETE CASCADE
);
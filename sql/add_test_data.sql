-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Asiakkaan testidata
INSERT INTO Asiakas(email, puh, etunimi, sukunimi, password) VALUES ('essi.esimerkki@gmail.com', '0441234567', 'Essi', 'Esimerkki', 'salasana');
-- Seurantalistan testidata
INSERT INTO Seurantalista(pvm) VALUES (current_timestamp);
-- Esitteen testidata
INSERT INTO Esite(aloitusHinta, avattu, sulkeutuu, kuvaus) VALUES (10.0, current_timestamp, TIMESTAMP '2017-04-01 15:36:38', 'Kaunis pallo');
-- Tarjouksen testidata
INSERT INTO Tarjous VALUES (1, 1, 1, 15.0, current_timestamp);
-- Tuoteluokan testidata
INSERT INTO Tuoteluokka(nimi) VALUES ('Urheilu');
-- EsitteenTuoteluokan testidata
INSERT INTO EsitteenTuoteluokka VALUES (1, 1);
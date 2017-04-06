-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Asiakkaan testidata
INSERT INTO Asiakas(email, puh, etunimi, sukunimi, password, onkoAdmin) VALUES ('essi.esimerkki@gmail.com', '0441234567', 'Essi', 'Esimerkki', 'salasana', '0');
INSERT INTO Asiakas(email, puh, etunimi, sukunimi, password, onkoAdmin) VALUES ('admin', '123', 'Admin', 'Admin', 'admin', '1');
-- Seurantalistan testidata
INSERT INTO Seurantalista(pvm) VALUES (current_timestamp);
-- Esitteen testidata
INSERT INTO Esite(nimi, aloitusHinta, avattu, sulkeutuu, kuvaus) VALUES ('Jalkapallo', 10.0, current_timestamp, TIMESTAMP '2017-04-01 15:36:38', 'Kaunis pallo');
INSERT INTO Esite(nimi, aloitusHinta, avattu, sulkeutuu, kuvaus) VALUES ('Lenkkarit', 27.5, current_timestamp, TIMESTAMP '2017-04-06 15:36:38', 'KIVAT KENGÄT');
-- Tarjouksen testidata
INSERT INTO Tarjous VALUES (1, 1, 1, 15.0, current_timestamp);
-- Tuoteluokan testidata
INSERT INTO Tuoteluokka(nimi) VALUES ('Urheilu');
-- EsitteenTuoteluokan testidata
INSERT INTO EsitteenTuoteluokka VALUES (1, 1);
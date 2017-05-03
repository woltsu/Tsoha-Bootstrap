<?php

$routes->get('/', function() {
    YleisController::etusivu();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/etusivu', function() {
    HelloWorldController::etusivu();
});

$routes->get('/esitteet', function() {
    EsiteController::index();
});

$routes->post('/esitteet/lisaaEsite', function() {
    EsiteController::store();
});

$routes->get('/esitteet/lisaa', function() {
    EsiteController::lisaa();
});

$routes->get('/esitteet/:id', function($id) {
    EsiteController::show($id);
});

$routes->post('/esitteet/:id', function($id) {
    TarjousController::store($id);
});


$routes->get('/esitteet/:id/muokkaa', function($id) {
    EsiteController::muokkaa($id);
});

$routes->post('/esitteet/:id/muokkaa', function($id) {
    EsiteController::paivita($id);
});

$routes->post('/esitteet/:id/destroy', function($id) {
    EsiteController::poista($id);
});

$routes->get('/esitteet/:id/tarjoukset', function($id) {
    TarjousController::show($id);
});

$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    YleisController::login();
});
$routes->post('/login', function() {
    // Kirjautumisen käsittely
    YleisController::handle_login();
});

$routes->post('/logout', function() {
    YleisController::logout();
});

$routes->get('/register', function() {
    YleisController::register();
});

$routes->post('/register', function() {
    YleisController::handle_register();
});

$routes->post('/esitteet/', function() {
    EsiteController::lisaaTuoteluokka();
});

$routes->get('/tuoteluokat', function() {
    TuoteluokkaController::index();
});

$routes->get('/tuoteluokat/:id', function($id) {
    TuoteluokkaController::edit($id);
});

$routes->post('/tuoteluokat/lisaa', function() {
    TuoteluokkaController::store();
});

$routes->post('/tuoteluokat/:id/destroy', function($id) {
    TuoteluokkaController::destroy($id);
});

$routes->post('/tuoteluokat/:id/edit', function($id) {
    TuoteluokkaController::update($id);
});



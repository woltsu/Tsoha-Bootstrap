<?php

$routes->get('/', function() {
    HelloWorldController::index();
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

$routes->post('/esitteet', function() {
    EsiteController::store();
});

$routes->get('/esitteet/lisaa', function() {
    EsiteController::lisaa();
});

$routes->get('/esitteet/:id', function($id) {
    EsiteController::show($id);
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

$routes->get('/admin', function() {
    HelloWorldController::adming_page();
});

$routes->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  AsiakasController::login();
});
$routes->post('/login', function(){
  // Kirjautumisen käsittely
  AsiakasController::handle_login();
});


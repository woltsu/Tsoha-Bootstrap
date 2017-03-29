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

$routes->get('/esitteet/:id/muokkaa', function() {
    HelloWorldController::product_edit();
});

$routes->get('/admin', function() {
    HelloWorldController::adming_page();
});

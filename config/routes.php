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
  
  $routes->get('/urheilu', function() {
      HelloWorldController::product_list();
  });
  
  $routes->get('/urheilu/1', function() {
      HelloWorldController::product_show();
  });
  
  $routes->get('/urheilu/1/muokkaa', function() {
      HelloWorldController::product_edit();
  });
  
  $routes->get('/admin', function() {
      HelloWorldController::adming_page();
  });
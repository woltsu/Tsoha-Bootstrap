<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        //View::make('home.html');
        self::etusivu();
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $pallo = new Esite(array('nimi' => null, 'kuvaus' => ''));
        $errors = $pallo->errors();
        Kint::dump($errors);
    }

}

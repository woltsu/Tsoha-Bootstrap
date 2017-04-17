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

    public static function etusivu() {
        View::make('suunnitelmat/etusivu.html');
    }

    public static function product_list() {
        View::make('suunnitelmat/product_list.html');
    }

    public static function product_show() {
        View::make('suunnitelmat/product_show.html');
    }

//    public static function product_edit() {
//        View::make('suunnitelmat/product_edit.html');
//    }

//    public static function adming_page() {
//        View::make('suunnitelmat/admin_page.html');
//    }

}

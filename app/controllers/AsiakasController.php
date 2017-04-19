<?php

class AsiakasController extends BaseController {

    public static function login() {
        View::make('yleiset_sivut/login.html');
    }
    
    public static function etusivu() {
        View::make('yleiset_sivut/etusivu.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $asiakas = Asiakas::authenticate($params['email'], $params['password']);

        if (!$asiakas) {
            View::make('yleiset_sivut/login.html', array('error' => 'Väärä sähköposti tai salasana!', 'email' => $params['email']));
        } else {
            $_SESSION['asiakas'] = $asiakas->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $asiakas->etunimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['asiakas'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}

<?php

class AsiakasController extends BaseController {

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $asiakas = Asiakas::authenticate($params['email'], $params['password']);

        if (!$asiakas) {
            View::make('suunnitelmat/login.html', array('error' => 'Väärä sähköposti tai salasana!', 'email' => $params['email']));
        } else {
            $_SESSION['asiakas'] = $asiakas->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $asiakas->etunimi . '!'));
        }
    }

}

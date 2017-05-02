<?php

class YleisController extends BaseController {

    public static function login() {
        View::make('yleiset_sivut/login.html');
    }

    public static function register() {
        View::make('yleiset_sivut/register.html');
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

    public static function handle_register() {
        $params = $_POST;
        $attributes = array('email' => $params['email'], 'password' => $params['password'], 'puh' => $params['puh'], 'etunimi' => $params['firstName'], 'sukunimi' => $params['lastName']);

        $pass1 = $params['password'];
        $pass2 = $params['passwordAgain'];

        if (strcmp($pass1, $pass2) != 0) {
            View::make('yleiset_sivut/register.html', array('error' => 'Tarkista, että olet kirjoittanut salasanat molemmissa kohdissa oikein!', 'attributes' => $attributes));
        } else {
            $asiakas = new Asiakas($attributes);
            $errors = $asiakas->errors();
            if (count($errors) == 0) {
                $asiakas->save();
                Redirect::to('/login', array('message' => 'Rekisteröityminen on onnistunut!'));
            } else {
                View::make('yleiset_sivut/register.html', array('attributes' => $attributes, 'errors' => $errors));
            }
        }
    }

    public static function logout() {
        $_SESSION['asiakas'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}

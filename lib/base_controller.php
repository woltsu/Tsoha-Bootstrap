<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        if (isset($_SESSION['asiakas'])) {
            $asiakas_id = $_SESSION['asiakas'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $asiakas = Asiakas::find($asiakas_id);

            return $asiakas;
        }
        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        if (!isset($_SESSION['asiakas'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function check_admin() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        if (!isset($_SESSION['asiakas'])) {
            Redirect::to('');
        } else {
            $asiakas_id = $_SESSION['asiakas'];
            $asiakas = Asiakas::find($asiakas_id);
            if (!$asiakas->onkoAdmin) {
                Redirect::to('/login');
            }
        }
    }

}

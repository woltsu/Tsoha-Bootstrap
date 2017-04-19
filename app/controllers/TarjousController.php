<?php

class TarjousController extends BaseController {

    public static function show($esite_id) {
        self::check_admin();
        $tarjoukset = Tarjous::all($esite_id);
        View::make("tarjoukset/tarjous_show.html", array('tarjoukset' => $tarjoukset));
    }

    public static function store($esite_id) {
        self::check_logged_in();
        $params = $_POST;

        $user_id = self::get_user_logged_in()->id;
        $esite = Esite::find($esite_id);

        $attributes = array('summa' => $params['summa'], 'esite_id' => $esite_id, 'asiakas_id' => $user_id);
        $tarjous = new Tarjous($attributes);

        $summa = $tarjous->summa;
        $aloitusHinta = $esite->aloitushinta;
        $suurinTarjous = Tarjous::suurin($esite_id)->summa;

        if ($summa < $aloitusHinta) {
            Redirect::to('/esitteet/' . $esite_id, array('error' => 'Summa ei saa olla lähtöhintaa pienempi!'));
        } else if ($summa <= $suurinTarjous) {
            Redirect::to('/esitteet/' . $esite_id, array('error' => 'Summan tulee olla suurempi kuin suurin tarjous!'));
        }

        $errors = $tarjous->errors();

        if (count($errors) == 0) {
            $tarjous->save();
            Redirect::to('/esitteet/' . $esite_id, array('message' => 'Tarjottu onnistuneesti!'));
            
            mail('oltsuwh@gmail.com', 'testi', 'joo');
        } else {
            Redirect::to('/esitteet/' . $esite_id, array('errors' => $errors));
        }
    }

}

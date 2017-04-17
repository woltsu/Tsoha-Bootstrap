<?php

class EsiteController extends BaseController {

    public static function index() {
        $esitteet = Esite::all();
        $tuoteluokat = Tuoteluokka::all();
        View::make("suunnitelmat/product_list.html", array('esitteet' => $esitteet, 'tuoteluokat' => $tuoteluokat));
    }

    public static function show($id) {
        $esite = Esite::find($id);
        $suurinTarjous = Tarjous::suurin($id);
        View::make("suunnitelmat/product_show.html", array('esite' => $esite, 'suurin' => $suurinTarjous));
    }

    public static function muokkaa($id) {
        self::check_admin();
        $esite = Esite::find($id);
        View::make("suunnitelmat/product_edit.html", array('esite' => $esite));
    }

    public static function paivita($id) {
        $params = $_POST;
        $attributes = array('nimi' => $params['name'], 'kuva' => $params['picture'], 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']);
        $esite = new Esite($attributes);
        $errors = $esite->errors();

        if (count($errors) == 0) {
            $esite->update($id);
            Redirect::to('/esitteet/' . $id, array('message' => 'Esitettä on muokattu onnistuneesti!'));
        } else {
            View::make("suunnitelmat/product_edit.html", array('esite' => Esite::find($id), 'errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function poista($id) {
        self::check_admin();
        $esite = new Esite(array('id' => $id));
        $esite->destroy();
        Redirect::to('/esitteet', array('message' => 'Esite on poistettu onnistuneesti!'));
    }

    public static function lisaa() {
        self::check_admin();
        $tuoteluokat = Tuoteluokka::all();
        View::make("suunnitelmat/lisaa.html", array('tuoteluokat' => $tuoteluokat));
    }

    public static function store() {
        $params = $_POST;
        $attributes = array('nimi' => $params['name'], 'kuva' => $params['picture'], 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']);
        $esite = new Esite($attributes);
        $errors = $esite->errors();

        if (count($errors) == 0) {
            $esite->save();
            
            $tuoteluokat = $params['tuoteluokat'];
            
            foreach ($tuoteluokat as $tuoteluokka) {
                $esitteenTuoteluokka = new EsitteenTuoteluokka(array('esite_id' => $esite->id, 'tuoteluokka_id' => $tuoteluokka));
                $esitteenTuoteluokka->save();
            }
            
            Redirect::to('/esitteet/' . $esite->id, array('message' => 'Uusi tuote on lisätty valikoimaan!'));
        } else {
            View::make('/suunnitelmat/lisaa.html', array('errors' => $errors, 'attributes' => $attributes, 'tuoteluokat' => Tuoteluokka::all()));
        }
    }

    public static function lisaaTuoteluokka() {
        $params = $_POST;

        $valinnat = $params['tuoteluokat'];
        $testi = array();

        foreach ($valinnat as $valinta) {
            $testi[] = Tuoteluokka::hae($valinta);
        }

        Redirect::to('/esitteet', array('valinnat' => $testi));
    }

}

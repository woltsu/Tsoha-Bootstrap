<?php

class EsiteController extends BaseController {

    public static function index() {
        $esitteet = Esite::all();
        View::make("suunnitelmat/product_list.html", array('esitteet' => $esitteet));
    }
    
    public static function show($id) {
        $esite = Esite::find($id);
        View::make("suunnitelmat/product_show.html", array('esite' => $esite));
    }

    public static function lisaa() {
        View::make("suunnitelmat/lisaa.html");
    }

    public static function store() {
        $params = $_POST;
        $esite = new Esite(array('nimi' => $params['name'], 'kuva' => $params['picture'], 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']));

        $esite->save();
        Redirect::to('/esitteet/' . $esite->id, array('message' => 'Peli on lisätty kirjastoosi!'));
    }

}

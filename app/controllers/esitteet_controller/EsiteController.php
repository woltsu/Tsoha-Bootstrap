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

    public static function muokkaa($id) {
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
        $esite = new Esite(array('id' => $id));
        $esite->destroy();
        Redirect::to('/esitteet', array('message' => 'Esite on poistettu onnistuneesti!'));
    }

    public static function lisaa() {
        View::make("suunnitelmat/lisaa.html");
    }

    public static function store() {
        $params = $_POST;
        $attributes = array('nimi' => $params['name'], 'kuva' => $params['picture'], 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']);
        $esite = new Esite($attributes);
        $errors = $esite->errors();

        if (count($errors) == 0) {
            $esite->save();
            Redirect::to('/esitteet/' . $esite->id, array('message' => 'Uusi tuote on lisätty valikoimaan!'));
        } else {
            View::make('/suunnitelmat/lisaa.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

}

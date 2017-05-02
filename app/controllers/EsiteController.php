<?php

class EsiteController extends BaseController {

    public static function index() {
        $esitteet = Esite::all();
        $tuoteluokat = Tuoteluokka::all();
        View::make("esite/product_list.html", array('esitteet' => $esitteet, 'tuoteluokat' => $tuoteluokat));
    }

    public static function show($id) {
        $esite = Esite::find($id);
        $suurinTarjous = Tarjous::suurin($id);
        $tuoteluokat = EsitteenTuoteluokka::haeTuoteluokatEsitteenPerusteella($id);
        View::make("esite/product_show.html", array('esite' => $esite, 'suurin' => $suurinTarjous, 'tuoteluokat' => $tuoteluokat));
    }

    public static function muokkaa($id) {
        self::check_admin();
        $esite = Esite::find($id);
        $tuoteluokat = Tuoteluokka::all();
        $esitteenTuoteluokat = EsitteenTuoteluokka::haeTuoteluokatEsitteenPerusteella($id);
        View::make("esite/product_edit.html", array('esite' => $esite, 'tuoteluokat' => $tuoteluokat, 'esitteenTuoteluokat' => $esitteenTuoteluokat));
    }

    public static function paivita($id) {
        $params = $_POST;

        try {
            $image = file_get_contents($_FILES['picture']['tmp_name']);
            $image = '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" height="400" width="600"/>';
        } catch (Exception $e) {
            $image = null;
        }
        $attributes = array('nimi' => $params['name'], 'kuva' => $image, 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']);
        $esite = new Esite($attributes);
        $errors = $esite->errors();

        if (count($errors) == 0) {
            $esite->update($id);
            EsitteenTuoteluokka::destroy($id);
            try {
                $tuoteluokat = $params['tuoteluokat'];
                foreach ($tuoteluokat as $tuoteluokka) {
                    $esitteenTuoteluokka = new EsitteenTuoteluokka(array('esite_id' => $id, 'tuoteluokka_id' => $tuoteluokka));
                    $esitteenTuoteluokka->save();
                }
            } catch (Exception $e) {
                
            }
            Redirect::to('/esitteet/' . $id, array('message' => 'Esitettä on muokattu onnistuneesti!'));
        } else {
            View::make("esite/product_edit.html", array('esite' => Esite::find($id), 'errors' => $errors, 'attributes' => $attributes, 'tuoteluokat' => Tuoteluokka::all()));
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
        View::make("esite/product_add.html", array('tuoteluokat' => $tuoteluokat));
    }

    public static function store() {
        $params = $_POST;

        try {
            $image = file_get_contents($_FILES['picture']['tmp_name']);
            $image = '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" height="400" width="600"/>';
        } catch (Exception $e) {
            $image = null;
        }

//        echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '"/>';
//        return;

        $attributes = array('nimi' => $params['name'], 'kuva' => $image, 'aloitushinta' => $params['startPrice'], 'sulkeutuu' => $params['ends'], 'kuvaus' => $params['description']);
        $esite = new Esite($attributes);
        $errors = $esite->errors();

        if (count($errors) == 0) {
            $esite->save();

            try {
                $tuoteluokat = $params['tuoteluokat'];
                foreach ($tuoteluokat as $tuoteluokka) {
                    $esitteenTuoteluokka = new EsitteenTuoteluokka(array('esite_id' => $esite->id, 'tuoteluokka_id' => $tuoteluokka));
                    $esitteenTuoteluokka->save();
                }
            } catch (Exception $e) {
                
            }

            Redirect::to('/esitteet/' . $esite->id, array('message' => 'Uusi tuote on lisätty valikoimaan!'));
        } else {
            View::make('/esite/product_add.html', array('errors' => $errors, 'attributes' => $attributes, 'tuoteluokat' => Tuoteluokka::all()));
        }
    }

    public static function lisaaTuoteluokka() {
        $params = $_POST;

        try {
            $valitutTuoteluokat = $params['tuoteluokat'];
        } catch (Exception $e) {
            EsiteController::index();
        }

        $valinnat = array();
        $esitteet = Esite::all_ids();

        foreach ($valitutTuoteluokat as $tuoteluokka) {
            $apu = array();
            $valinnat[] = Tuoteluokka::hae($tuoteluokka);
            $uudetEsitteet = EsitteenTuoteluokka::haeEsitteetTuoteluokanPerusteella($tuoteluokka);
            foreach ($esitteet as $esite) {
                if (in_array($esite, $uudetEsitteet)) {
                    $apu[] = $esite;
                }
            }
            $esitteet = $apu;
        }
        $lopullinen = array();
        foreach ($esitteet as $esite) {
            $lopullinen[] = Esite::find($esite);
        }

        //$esitteet = array_unique($esitteet);

        $tuoteluokat = Tuoteluokka::all();
//Redirect::to('/esitteet');
        View::make("esite/product_list.html", array('esitteet' => $lopullinen, 'tuoteluokat' => $tuoteluokat, 'valinnat' => $valinnat));
    }

}

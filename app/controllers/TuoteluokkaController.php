<?php

class TuoteluokkaController extends BaseController {

    public static function index() {
        self::check_admin();
        $tuoteluokat = Tuoteluokka::all();
        View::make('tuoteluokat/tuoteluokka_add.html', array('tuoteluokat' => $tuoteluokat));
    }

    public static function edit($id) {
        self::check_admin();
        $tuoteluokka = Tuoteluokka::hae($id);
        View::make('tuoteluokat/tuoteluokka_edit.html', array('tuoteluokka' => $tuoteluokka));
    }

    public static function destroy($id) {
        $params = $_POST;
        $id = $params['id'];
        $tuoteluokka = new Tuoteluokka(array('id' => $id));
        $tuoteluokka->destroy();
        Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka on poistettu onnistuneesti!'));
    }

    public static function update($id) {
        $params = $_POST;
        $tuoteluokka = new Tuoteluokka(array('nimi' => $params['name']));

        $errors = $tuoteluokka->errors();

        if (count($errors) == 0) {
            $tuoteluokka->update($id);
            Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokkaa on muokattu onnistuneesti!'));
        } else {
            View::make("tuoteluokat/tuoteluokka_edit.html", array('tuoteluokka' => Tuoteluokka::hae($id), 'errors' => $errors));
        }
    }

    public static function store() {
        $params = $_POST;
        $tuoteluokka = new Tuoteluokka(array('nimi' => $params['name']));

        $errors = $tuoteluokka->errors();

        if (count($errors) == 0) {
            $tuoteluokka->save();
            Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka on lisätty onnistuneesti!'));
        } else {
            $tuoteluokat = Tuoteluokka::all();
            View::make("tuoteluokat/tuoteluokka_add.html", array('tuoteluokat' => $tuoteluokat, 'errors' => $errors));
        }
    }

}
